<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Product;
use yii\web\UploadedFile;
use yii\web\Response;

class ProductController extends Controller
{
    public function actionCreate()
    {
        $model = new Product();
        $response = ['success' => false];

        if ($model->load(Yii::$app->request->post())) {
            // Verifica se foi feito o upload da foto
            $model->foto = UploadedFile::getInstance($model, 'foto');

            if ($model->validate()) {
                // Salva a foto e obtém o caminho de acesso
                $uploadPath = Yii::getAlias('@app') . '/uploads/products/';
                if ($model->foto) {
                    $filePath = $uploadPath . uniqid('foto_') . '.' . $model->foto->extension;
                    if ($model->foto->saveAs($filePath)) {
                        // Remove o caminho absoluto do caminho do arquivo
                        $filePath = str_replace('/web', '', $filePath);
                        $filePath = str_replace('/var/www/html', '', $filePath);
                        $model->foto = $filePath;
                    }
                }

                // Tenta salvar os outros dados do produto
                if ($model->save()) {
                    $response['success'] = true;
                    $response['message'] = 'Produto cadastrado com sucesso.';
                    $response['data'] = $model->attributes;
                } else {
                    $response['message'] = 'Erro ao cadastrar o produto.';
                }
            } else {
                // Caso haja erros de validação, adiciona-os à resposta
                $response['errors'] = $model->errors;
            }
        }

        // Retornar a resposta como JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }

    public function actionIndex($cliente_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = Product::find()->with('cliente');

        // Adiciona a condição para filtrar por cliente_id, se fornecido
        if ($cliente_id !== null) {
            $query->andWhere(['cliente_id' => $cliente_id]);
        }

        $pagination = new \yii\data\Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 10, // Defina o número de itens por página aqui
        ]);

        $products = $query->orderBy('nome')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // Montando os dados para retorno
        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->id,
                'nome' => $product->nome,
                'preco' => $product->preco,
                'cliente_id' => $product->cliente_id,
                'cliente' => $product->cliente ? $product->cliente->nome : null,
                'foto' => $product->foto,
            ];
        }

        return [
            'products' => $formattedProducts,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'pageSize' => $pagination->getPageSize(),
                'hasNextPage' => $pagination->getPage() < $pagination->getPageCount() - 1,
                'hasPrevPage' => $pagination->getPage() > 0,
            ],
        ];
    }
}
