<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchReplicate extends BatchAction
{
    public $name = '批量发货';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->update([
                'ship_status' => 'delivered'
            ]);
        }

        return $this->response()->success('发货成功！')->refresh();
    }
    public function dialog()
    {
        $this->confirm('确定发货？');
    }

}