<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DB;

class GennixCrud extends Command
{
    protected $signature = 'gennix:crud
        {name : Class name on singular mode. Example: User}
        {--all : Generate controller, model, requests, routes, migration, breadcrumbs, permissions and views}
        {--controller : Generate controller}
        {--model : Generate model}
        {--request : Generate requests (Update and Store)}
        {--views : Generate views}
        {--breadcrumbs : Generate breadcrumbs}
        {--routes : Generate routes}
        {--migration : Generate migration}
        {--permissions : Generate essentials permissions}';

    protected $description = 'Generate an basic CRUD for any Class';

    protected $modelName;
    protected $modelNamePlural;
    protected $modelNamePluralLowerCase;
    protected $modelNameSingularLowerCase;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $options = $this->options();

        $this->modelName = $name;
        $this->modelNamePlural = Str::plural($name);
        $this->modelNameSingularLowerCase = Str::lower($name);
        $this->modelNamePluralLowerCase = Str::lower(Str::plural($name));

        if ($options['controller'] || $options['all']) {
            $this->info('Generating the controller...');
            $this->controller();
        }

        if ($options['model'] || $options['all']) {
            $this->info('Generating the model...');
            $this->model();
        }

        if ($options['request'] || $options['all']) {
            $this->info('Generating the requests...');
            $this->request();
        }

        if ($options['routes'] || $options['all']) {
            $this->info('Generating the rota...');
            $this->routes();
        }

        if ($options['views'] || $options['all']) {
            $this->info('Generating the views...');
            $this->views();
        }

        if ($options['breadcrumbs'] || $options['all']) {
            $this->info('Generating the breadcrumbs...');
            $this->createBreadcrumbs();
        }

        if ($options['migration'] || $options['all']) {
            $this->info('Generating the migration...');
            $this->createMigration();
        }

        if ($options['permissions'] || $options['all']) {
            $this->info('Generating the essential permissions...');
            $this->createPermissions();
        }
    }

    protected function model()
    {
        $modelTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/{$this->modelName}.php"), $modelTemplate);
    }

    protected function controller()
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePluralLowerCase,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$this->modelName}Controller.php"), $controllerTemplate);
    }

    protected function request()
    {
        $this->updateRequest();
        $this->storeRequest();
    }

    protected function updateRequest()
    {
        $requestTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('UpdateRequest')
        );

        if (!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/{$this->modelName}UpdateRequest.php"), $requestTemplate);
    }

    protected function storeRequest()
    {
        $requestTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('StoreRequest')
        );

        if (!file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/{$this->modelName}StoreRequest.php"), $requestTemplate);
    }

    protected function routes()
    {
        File::append(
            base_path('routes/web.php'),
            '
/**
 * ---------------------------------------------------
 * Rotas para a classe ' . $this->modelName . '
 * ---------------------------------------------------
 */
Route::resource(\'' . $this->modelNameSingularLowerCase . "', '{$this->modelName}Controller');
"
        );
    }

    protected function createMigration()
    {
        $table = Str::snake($this->modelName);

        $this->call('make:migration', ['name' => 'create_' . $table . '_table', '--create' => $table]);
    }


    protected function createPermissions()
    {
        $permissions = [
            [
                'slug' => $this->modelNameSingularLowerCase . '-access',
                'description' => 'Acessar o ' . $this->modelName . ' pelo menu lateral',
            ],
            [
                'slug' => $this->modelNameSingularLowerCase . '-create',
                'description' => 'Criar um novo registro de ' . $this->modelName,
            ],
            [
                'slug' => $this->modelNameSingularLowerCase . '-edit',
                'description' => 'Editar um registro de ' . $this->modelName,
            ],
            [
                'slug' => $this->modelNameSingularLowerCase . '-show',
                'description' => 'Exibir os detalhes de um registro de ' . $this->modelName,
            ],
            [
                'slug' => $this->modelNameSingularLowerCase . '-delete',
                'description' => 'Excluir um registro de ' . $this->modelName,
            ],
        ];

        foreach ($permissions as $permission) {
            $this->info('Creating permission ' . $permission['slug']);

            DB::table('permissions')->insert(
                [
                    'title' => $permission['description'],
                    'slug' => $permission['slug'],
                    'created_at' => now(),
                ]
            );
        }
    }


    protected function views()
    {
        $path = resource_path('views/admin/' . $this->modelNameSingularLowerCase);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $this->viewIndex();
        $this->viewCreate();
        $this->viewEdit();
        $this->viewShow();
    }


    protected function createBreadcrumbs()
    {
        $breadcrumbs = '
// Dashboard > ' . $this->modelName . '
Breadcrumbs::for(\'' . $this->modelNameSingularLowerCase . '\', function ($trail) {
    $trail->parent(\'dashboard\');
    $trail->push(__(\'gennix.breadcrumbs.' . $this->modelNameSingularLowerCase . '\'), route(\'' . $this->modelNameSingularLowerCase . '.index\'));
});

// Dashboard > ' . $this->modelName . ' > Details
Breadcrumbs::for(\'' . $this->modelNameSingularLowerCase . '_show\', function ($trail) {
    $trail->parent(\'' . $this->modelNameSingularLowerCase . '\');
    $trail->push(__(\'gennix.breadcrumbs.details\'));
});

// Dashboard > ' . $this->modelName . ' > Create
Breadcrumbs::for(\'' . $this->modelNameSingularLowerCase . '_create\', function ($trail) {
    $trail->parent(\'' . $this->modelNameSingularLowerCase . '\');
    $trail->push(__(\'gennix.breadcrumbs.create\'));
});

// Dashboard > ' . $this->modelName . ' > Edit
Breadcrumbs::for(\'' . $this->modelNameSingularLowerCase . '_edit\', function ($trail) {
    $trail->parent(\'' . $this->modelNameSingularLowerCase . '\');
    $trail->push(__(\'gennix.breadcrumbs.edit\'));
});
';

        File::append(
            base_path('routes/breadcrumbs.php'),
            $breadcrumbs
        );
    }


    protected function viewIndex()
    {
        $viewIndexTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Index')
        );

        file_put_contents(resource_path('views/admin/' . $this->modelNameSingularLowerCase . '/index.blade.php'), $viewIndexTemplate);
    }

    protected function viewCreate()
    {
        $viewCreateTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Create')
        );

        file_put_contents(resource_path('views/admin/' . $this->modelNameSingularLowerCase . '/create.blade.php'), $viewCreateTemplate);
    }

    protected function viewEdit()
    {
        $viewEditTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Edit')
        );

        file_put_contents(resource_path('views/admin/' . $this->modelNameSingularLowerCase . '/edit.blade.php'), $viewEditTemplate);
    }

    protected function viewShow()
    {
        $viewShowTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Show')
        );

        file_put_contents(resource_path('views/admin/' . $this->modelNameSingularLowerCase . '/show.blade.php'), $viewShowTemplate);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
}
