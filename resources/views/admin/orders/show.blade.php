<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">订单流水号：{{ $order->no }}</h3>
        <div class="box-tools">
            <div class="btn-group float-right" style="margin-right: 10px">
                <a href="/admin/orders" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 列表</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>买家：</td>
                <td>{{ $order->user->nickname }}</td>
            </tr>
            <tr>
                <td>收货人</td>
                <td>{{ $order->address['contact_name'] }}</td>
                <td>电话</td>
                <td>{{ $order->address['contact_phone'] }}</td>
            </tr>
            <tr>
                <td>收货地址</td>
                <td colspan="3">{{ $order->address['address'] }} </td>
            </tr>
            <tr>
                <td rowspan="{{ $order->items->count() + 1 }}">商品列表</td>
                <td>商品名称</td>
                <td>单价</td>
                <td>数量</td>
            </tr>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->title }} </td>
                    <td>￥{{ $item->price }}</td>
                    <td>{{ $item->amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td>订单金额：</td>
                <td>￥{{ $order->total_amount }}</td>
                <!-- 这里也新增了一个发货状态 -->
                <td>发货状态：</td>
                <td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
            </tr>
            <!-- 订单发货开始 -->
            <!-- 如果订单未发货，展示发货表单 -->
            @if($order->ship_status === \App\Models\Order::SHIP_STATUS_PENDING) @endif
            {{--<tr>--}}
                {{--<td>--}}
                    {{--<form>--}}
                        {{--<button type="submit" class="btn btn-default" id="ship-btn">发货</button>--}}
                    {{--</form>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<form>--}}
                        {{--<button type="submit" class="btn btn-default" id="ship-btn">确认收获</button>--}}
                    {{--</form>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<form>--}}
                        {{--<button type="submit" class="btn btn-default" id="ship-btn">取消</button>--}}
                    {{--</form>--}}
                {{--</td>--}}
                {{--<td>{{ $order->ship_data['express_no'] }}</td>--}}
            {{--</tr>--}}
            </tbody>

        </table>


        <!-- 这里也新增了一个发货状态 -->


    </div>
</div>