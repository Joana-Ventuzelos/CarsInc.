<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statements = $this->loadParseSQLStatements(
            database_path('script/locacao_carros.sql')
        );

        [$createStatements, $otherStatements] = $this->separateStatements($statements);

        $this->executeStatements($createStatements, 'CREATE TABLE');
        $this->executeStatements($otherStatements, 'OUTROS');
    }


    private function loadParseSQLStatements(string $path): array
    {
        if (!file_exists($path)) {
            throw new \Exception('O arquivo SQL não foi encontrado em: ' . $path);
        }

        $sql = file_get_contents($path);
        return $this->splitSQLStatements($sql);
    }

    private function separateStatements(array $statements): array
    {
        $create = [];
        $others = [];

        foreach ($statements as $statement) {
            if (preg_match('/\bCREATE\s+TABLE\b/i', $statement)) {
                $create[] = $statement;
            } elseif (!preg_match('/\b(DELETE|DROP|TRUNCATE|ALTER|UPDATE)\b/i', $statement)) {
                $others[] = $statement;
            }
        }

        return [$create, $others];
    }

    private function executeStatements(array $statements, string $type): void
    {
        logger()->alert("Executando instruções SQL do tipo: {$type}", ['count' => count($statements)]);

        foreach ($statements as $statement) {
            if (!empty($statement)) {
                DB::unprepared($statement . ';');
            }
        }
    }

    private function splitSQLStatements(string $sql): array
    {
        $statements = [];
        $buffer = '';
        $inString = false;
        $stringChar = '';

        for ($i = 0; $i < strlen($sql); $i++) {
            $char = $sql[$i];

            // Detectar início/fim de string
            if (($char === "'" || $char === '"') && ($i === 0 || $sql[$i - 1] !== '\\')) {
                if ($inString && $char === $stringChar) {
                    $inString = false;
                } elseif (!$inString) {
                    $inString = true;
                    $stringChar = $char;
                }
            }

            $buffer .= $char;

            if ($char === ';' && !$inString) {
                $statements[] = trim($buffer);
                $buffer = '';
            }
        }

        if (trim($buffer) !== '') {
            $statements[] = trim($buffer);
        }

        return $statements;
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
