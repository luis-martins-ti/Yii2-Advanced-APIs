<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $cep
 * @property string $logradouro
 * @property string $numero
 * @property string $cidade
 * @property string $estado
 * @property string|null $complemento
 * @property string|null $foto
 * @property string $sexo
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    public function rules()
    {
        return [
            [['nome', 'cpf', 'cep', 'logradouro', 'numero', 'cidade', 'estado', 'sexo'], 'required', 'message' => 'Este campo é obrigatório.'],
            ['cpf', 'unique', 'message' => 'Este CPF já está em uso.'],
            ['cpf', 'string', 'max' => 14, 'tooLong' => 'O CPF deve ter no máximo 14 caracteres.'],
            ['cpf', 'validarCpf'], // Mantém a chamada para a sua validação personalizada
            [['cep', 'numero'], 'string', 'max' => 10, 'tooLong' => 'O CEP deve ter no máximo 10 caracteres.'],
            [['logradouro', 'cidade', 'estado', 'complemento'], 'string', 'max' => 255, 'tooLong' => 'Limite Máximo de 255 caracteres.'],
            [['foto'], 'file', 'extensions' => 'png, jpg, jpeg', 'wrongExtension' => 'A foto deve ser um arquivo PNG, JPG ou JPEG.'],
            [['sexo'], 'in', 'range' => ['masculino', 'feminino', 'não binário'], 'message' => 'Por favor, selecione um sexo válido. (masculino, feminino, não binário)'],
        ];
    }

    public function validarCpf($attribute, $params)
    {
        $cpf = preg_replace('/[^0-9]/', '', $this->$attribute);

        if (strlen($cpf) != 11 || preg_match('/^(\d)\1+$/', $cpf)) {
            $this->addError($attribute, 'CPF inválido.');
            return;
        }

        for ($i = 9; $i < 11; $i++) {
            $j = 0;
            $soma = 0;

            for ($j = 0; $j < $i; $j++) {
                $soma += $cpf[$j] * (($i + 1) - $j);
            }

            $soma %= 11;
            $digito = ($soma < 2) ? 0 : 11 - $soma;

            if ($cpf[$i] != $digito) {
                $this->addError($attribute, 'CPF inválido.');
                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'cep' => 'Cep',
            'logradouro' => 'Logradouro',
            'numero' => 'Numero',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'complemento' => 'Complemento',
            'foto' => 'Foto',
            'sexo' => 'Sexo',
        ];
    }
}
