<?php


namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;

class Index extends Controller
{

    public function index()
    {
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/welcome.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/welcome.html';
        }
        $this->response()->write(file_get_contents($file));
    }

    function test()
    {
        $this->response()->withHeader('Content-type', 'application/json');
        $this->response()->withStatus(200);
        $this->response()->write(json_encode([
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'time' => time(),
                'ip' => $this->request()->getHeader('x-forwarded-for')[0] ?? $this->request()->getServerParams()['remote_addr'] ?? '',
            ],
        ]));
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if(!is_file($file)){
            $file = EASYSWOOLE_ROOT.'/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }
}