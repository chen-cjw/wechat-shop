<div id="app" class=" " style="">

    <section class="content" style="">


        <div class="row" style=""><div class="col-md-12" style="">
                <div class="box box-info" style="">
                    <div class="box-header with-border">
                        <h3 class="box-title">创建</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="/admin/product/collect" method="post" accept-charset="UTF-8" class="form-horizontal" style="">
                        @csrf
                        <div class="box-body" style="">
                            <div class="fields-group" style="">
                                <div class="form-group">
                                    <label for="is_pub" class="col-sm-2  control-label">分类名</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="category_id">
                                            @foreach($cateArr as $cateItem)
                                                <option value="{{$cateItem->id}}">{{$cateItem->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="is_pub" class="col-sm-2  control-label">商品类型</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type">
                                            <option value="common" selected="">普通</option>
                                            <option value="hot">热销</option>
                                            <option value="recommend">推荐</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group  ">
                                    <label for="name" class="col-sm-2  control-label">采集地址</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="name" name="collect_url" value="" class="form-control name" placeholder="输入 浏览器地址">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group  ">
                                    <label for="price" class="col-sm-2  control-label">价格</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-terminal fa-fw"></i></span>
                                            <input style="width: 130px; text-align: right;" type="text" id="price" name="price" value="0" class="form-control price" placeholder="输入 价格">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <div class="btn-group pull-right">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>

            </div></div>

    </section>
</div>
