<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Criar uma nova classe de serviço em app/Services';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services');

        if (!File::exists($servicePath)) {
            File::makeDirectory($servicePath, 0755, true);
        }

        $filePath = $servicePath . '/' . $name . '.php';

        if (File::exists($filePath)) {
            $this->error('O serviço já existe!');
            return;
        }

        $content = "<?php
        namespace App\Services;

        use Illuminate\Support\Facades\Http;
        use Illuminate\Support\Facades\Session;
        use Illuminate\Support\Str;

        class {$name}
        {
            //adicione os métodos a seguir, como o exemplo:
            // public function create()
            // {
            // }
        }";

        File::put($filePath, $content);

        $this->info("Serviço {$name} criado com sucesso!");
    }
}
