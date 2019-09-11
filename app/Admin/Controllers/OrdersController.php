<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchReplicate;
use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;


class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->column('id', __('Id'));
        $grid->column('no', __('订单号'));
        $grid->column('user.openid', __('用户唯一标识'));
        //$grid->column('address', __('Address'));
        $grid->column('total_amount', __('总金额'));
//        $grid->column('ship_status','物流')->radio([
//            'pending' => '未发货', 'delivered' => '已发货',
//            'received' => '已收货',
//            'close' => '取消',
//        ]);
        $grid->column('ship_status','物流')->editable('select', [
            'pending' => '未发货', 'delivered' => '已发货',
            'received' => '已收货',
            'close' => '取消',
        ]);


        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        // 禁用创建按钮，后台不需要创建订单
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 禁用删除和编辑按钮
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->batchActions(function ($batch) {
            $batch->add(new BatchReplicate());
        });
        $grid->filter(function ($filter) {
            $filter->expand();
            $filter->column(1/2, function ($filter) {
                $filter->between('created_at', '创建时间')->datetime();
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('no', '订单号');
                $filter->equal('ship_status','物流')->multipleSelect([
                    'pending' => '未发货',
                    'delivered' => '已发货',
                    'received' => '已收货',
                    'close' => '取消'
                ]);
            });


        });

        return $grid;
    }

    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body(view('admin.orders.show', ['order' => Order::find($id)]));
    }
    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('no', __('No'));
        $show->field('user_id', __('User id'));
        $show->field('address', __('Address'));
        $show->field('total_amount', __('Total amount'));
        $show->field('remark', __('Remark'));
        $show->field('ship_status', __('Ship status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->text('no', __('No'));
        $form->number('user_id', __('User id'));
        $form->textarea('address', __('Address'));
        $form->decimal('total_amount', __('Total amount'));
        $form->textarea('remark', __('Remark'));
        $form->text('ship_status', __('Ship status'))->default('pending');

        return $form;
    }

    public function confirm($id)
    {
        Order::where('id',$id)->update([
            'ship_status' => 'delivered'
        ]);
        return redirect()->back();
    }
}
