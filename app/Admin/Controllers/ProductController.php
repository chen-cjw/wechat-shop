<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Goutte\Client;
use Encore\Admin\Layout\Content;


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
        $grid->column('image', __('商品封面图片文件路径'))->lightbox(['width' => 20, 'height' => 20]);

        $grid->column('stock', __('库存'));
        $grid->column('sold_count', __('销量'));
        $grid->column('price', __('价格'));

        //admin/product/7
        $grid->column('price', __('价格'));
        // 全部关闭
        $grid->disableActions();
        // 去掉批量操作
        $grid->disableBatchActions();

        $grid->column('type', __('商品类型'))->display(function ($type) {
            if($type =='hot')
                return '<button type="button" class="btn btn-danger btn-xs">热销</button>';
            if($type =='recommend')
                return '<button type="button" class="btn btn-success btn-xs">推荐</button>';
            if($type =='common')
                return '<button type="button" class="btn btn-default btn-xs">普通</button>';
        });;
        $grid->column('on_sale', __('商品是否正在售卖'))->display(function ($on_sale) {
            return $on_sale == 1 ? '<button type="button" class="btn btn-primary btn-xs">是</button>' : '<button type="button" class="btn btn-default btn-xs">否</button>';
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function ($filter) {
            $filter->expand();
            $filter->column(1/2, function ($filter) {
                $filter->like('title', '商品名称');
                $filter->between('created_at', '创建时间')->datetime();

            });
            $filter->column(1/2, function ($filter) {
                $filter->like('category_id', '分类名')->select(Category::pluck('title','id'));

                $filter->equal('on_sale', '是否售卖')->select([1 => '是', 0 => '否']);
                $filter->equal('type','商品类型')->select(['hot' => '热销','recommend' => '推荐','common' => '普通']);

            });
        });
        $grid->column('update', __('操作'))->display(function () {
            return "<a href="."/admin/product/".$this->id."/edit".">编辑</a>".'||'.
                "<a href="."/admin/product/".$this->id.">详情</a>";
        });
//                         <button type="submit" class="btn btn-success" id="ship-btn">发货</button>
        $grid->tools(function (Grid\Tools $tools) {
            // "<a class='report-posts btn btn-sm btn-danger'><i class='fa fa-info-circle'></i>举报</a>"
            $tools->append("<a href='/admin/product/collectIndex' target='_blank' style='float: right' class='report-posts btn btn-sm btn-danger'>采集</a>");
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
        $show->field('image', __('商品封面图片文件路径'))->image('',100,100);
        $show->field('on_sale', __('商品是否正在售卖'));
        $show->field('stock', __('库存'));
        $show->field('sold_count', __('销量'));
        $show->field('price', __('价格'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('description', __('商品详情'))->unescape();

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

        $form->select('category_id', __('分类名'))->options(Category::pluck('title','id'))->rules('required');
        $form->select('type', __('商品类型'))->default('common')->options(['hot'=>'热销','recommend'=>'推荐','common'=>'普通']);

        $form->text('title', __('商品名称'))->rules('required');
        $form->UEditor('description', __('商品详情'))->rules('required');
        $form->multipleImage('image', __('商品封面图片文件路径'))->removable();
        $form->switch('on_sale', __('商品是否正在售卖'))->default(1);
        $form->number('stock', __('库存'))->default(0);
        $form->number('sold_count', __('销量'))->default(0);
        $form->decimal('price', __('价格'))->default(0.00);
//        hot=>热销|recommend=>推荐|common=>普通
        $categoryId = request()->category_id;
        $isAjax = request()->ajax();
        if(!$isAjax) {
            $form->saving(function ($form) use ($categoryId) {
                $form->model()->category_id = $categoryId;
            });
        }


        return $form;
    }

    public function collectIndex(Content $content)
    {
        return $content
        ->title($this->title())
        ->description('采集')
        ->body(view('product',['cateArr'=>Category::get()]));
    }
    // 采集数据
    public function collect()
    {

        $client = new Client();
        $url = request()->collect_url;

        $url = str_replace("https://product.suning.com/","https://m.suning.com/product/",$url);
        $crawler = $client->request('GET', $url);
        // 商品名称
        $title = $slogan = $crawler->filter('div.product-title>h1')->html();
        //$name = explode('</span>',$crawler->filter('div.proinfo-title > h1')->html())[2];
        // 商品详情
        $description = $crawler->filter('div.content-detail')->html();
        //商品封面图片文件路径
        $banCount = $crawler->filter('span.pic-nav-count')->text();
        $bannerArr = array();
        for ($x=0; $x<(int)$banCount; $x++) {
            $bannerItem = $crawler->filter('div.pic-slider>div.pic-item>a>img')->eq($x)->attr('ori-src');
            $bannerArr[] = $bannerItem ? 'https://'.$bannerItem : 'https://'.$crawler->filter('div.pic-slider>div.pic-item>a>img')->eq($x)->attr('data-src');
        }
        $data = [
            'title'=>$title,
            'description'=>$description,
            'image'=>$bannerArr,
            'price'=>request()->price,
            'type'=>request()->type,
            'category_id'=>request()->category_id,
            'on_sale'=>false,
        ];

        Product::create($data);
        admin_success($title, '采集成功');
        return redirect('/admin/product');
    }
    
    
}
