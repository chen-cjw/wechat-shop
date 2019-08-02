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
        $grid->column('title', __('分类名'));
        $grid->column('sort_num', __('Sort num'))->sortable();

        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
        $grid->column('add_product', '商品')->display(function () {
            return "<a href='/admin/category/{$this->id}/product/create'  target='_blank'>添加</a>"."|"."<a href='/admin/category/{$this->id}/product' target='_blank'>查看</a>";
        });
        $grid->filter(function ($filter) {
            $filter->like('title', '分类名');
            $filter->between('created_at', '创建时间')->datetime();

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

        $form->text('title', __('分类名'));
        $form->text('sort_num', __('Sort num'));

        return $form;
    }
}
