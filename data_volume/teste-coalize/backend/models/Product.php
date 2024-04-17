<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $nome
 * @property float $preco
 * @property int $cliente_id
 * @property string|null $foto
 *
 * @property Client $cliente
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'preco', 'cliente_id'], 'required', 'message' => 'Este campo é obrigatório.'],
            [['preco'], 'double', 'message' => 'O preço deve ser um número válido.'],
            [['preco'], 'validarFormatoDecimal'], // Mantém a chamada para a sua validação personalizada
            [['cliente_id'], 'integer', 'message' => 'O ID do cliente deve ser um número inteiro.'],
            [['nome'], 'string', 'max' => 255, 'tooLong' => 'O nome deve ter no máximo 255 caracteres.'],
            [['foto'], 'file', 'extensions' => 'png, jpg, jpeg', 'wrongExtension' => 'A foto deve ser um arquivo PNG, JPG ou JPEG.'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['cliente_id' => 'id'], 'message' => 'O cliente selecionado não existe.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'preco' => 'Preço',
            'cliente_id' => 'Cliente ID',
            'foto' => 'Foto',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Client::class, ['id' => 'cliente_id']);
    }

    public function validarFormatoDecimal($attribute, $params)
    {
        if (!preg_match('/^\d+(\.\d{1,2})?$/', $this->$attribute)) {
            $this->addError($attribute, 'O preço deve ser um número válido com até duas casas decimais.');
        }
    }
}
