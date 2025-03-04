<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cart;

class CreateOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|numeric|min:1',
        ];
    }

    public function prepareForValidation()
    {
        // カートの数量を取得
        $cart = Cart::find($this->route('cart')); // 'cart'はルートパラメータ名に合わせて変更

        // リクエストのquantityが空またはnullの場合、カートの数量をデフォルト値として設定
        $this->merge([
            'quantity' => $this->input('quantity', $cart ? $cart->number : 1), // カートが存在しない場合は1をデフォルトに
        ]);
    }
}
