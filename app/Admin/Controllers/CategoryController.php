<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use function foo\func;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类名';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);
        $grid->column('id', __('Id'))->sortable();
        $grid->column('image', __('分类缩略图'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('title', __('分类名'));
        $grid->column('sort_num', __('Sort num'))->sortable();

        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
//        $grid->column('add_product', '商品添加')->display(function () {
//            return "<a href='/product' target='_blank'>查看</a>";
//        });

        $grid->filter(function ($filter) {
            $filter->expand();
            $filter->column(1/2, function ($filter) {
                $filter->between('created_at', '创建时间')->datetime();
            });
            $filter->column(1/2, function ($filter) {
                $filter->like('title', '分类名');
            });

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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('分类名'));
        $show->field('sort_num', __('Sort num'));
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
        $form = new Form(new Category);

        $form->text('title', __('分类名'))->rules('required');
        $form->text('sort_num', __('Sort num'))->default(0);
        $form->image('image', __('分类缩略图'))->rules('required');

        return $form;
    }
}
