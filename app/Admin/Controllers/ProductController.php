<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);
        if ($category_id = request()->category_id) {
            $grid->model()->where('category_id',$category_id);
        }
        $grid->model()->orderBy('id','desc');
        $grid->column('id', __('Id'));
        $grid->category()->title('分类名');
        $grid->column('title', __('商品名称'));
        $grid->column('image', __('商品封面图片文件路径'))->lightbox(['width' => 50, 'height' => 50]);

        $grid->column('stock', __('库存'));
        $grid->column('sold_count', __('销量'));
        $grid->column('price', __('价格'));
        $grid->column('on_sale', __('商品是否正在售卖'))->display(function ($on_sale) {
            return $on_sale == 1 ? '是' : '否';
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function ($filter) {
            $filter->like('title', '商品名称');
            $filter->between('created_at', '创建时间')->datetime();
            $filter->equal('on_sale','商品是否正在售卖')->select([1 => '是',0 => '否']);
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('商品名称'));
        $show->field('description', __('商品详情'))->unescape();
        $show->field('image', __('商品封面图片文件路径'))->image();
        $show->field('on_sale', __('商品是否正在售卖'));
        $show->field('stock', __('库存'));
        $show->field('sold_count', __('销量'));
        $show->field('price', __('价格'));
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
        $form = new Form(new Product);

        $form->text('title', __('商品名称'));
        $form->UEditor('description', __('商品详情'));
        $form->image('image', __('商品封面图片文件路径'));
        $form->switch('on_sale', __('商品是否正在售卖'))->default(1);
        $form->number('stock', __('库存'));
        $form->number('sold_count', __('销量'));
        $form->decimal('price', __('价格'));
        $categoryId = request()->route('category_id');
        $form->saving(function ($form) use ($categoryId) {
            $form->model()->category_id = $categoryId;
        });

        return $form;
    }
}
