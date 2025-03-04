<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Product;
use App\Models\OrderDetail;

class EditOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証ロジックを適用する場合は変更
    }

    public function rules()
    {
        return [
            'quantities.*' => 'required|integer|min:1', // 'quantities.*' に修正
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 量が入っていない場合、バリデーションエラーを追加
            if (!is_array($this->quantities)) {
                return; // quantitiesが配列でない場合は処理をスキップ
            }

            // 数量ごとの検証処理
            foreach ($this->quantities as $detailId => $quantity) {
                $orderDetail = OrderDetail::find($detailId);

                if (!$orderDetail) {
                    continue; // OrderDetailが見つからない場合はスキップ
                }

                $product = $orderDetail->product;

                // 在庫制限のチェック
                if ($product && $quantity > $product->lot) {
                    // エラーメッセージを追加
                    $validator->errors()->add("quantities.$detailId", "在庫が不足しています。最大注文可能数は {$product->lot} です。");
                }
            }
        });
    }
}
