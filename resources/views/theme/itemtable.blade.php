<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Delivery Time</th>
            <th>Item Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($getitem as $item) {
            // print_r($item);
        ?>
        <tr id="dataid{{$item->id}}">
            <td>{{$item->id}}</td>
            <td>{{$item['category']->category_name}}</td>
            <td>{{$item->item_name}}</td>
            <td>{{$item->item_price}}</td>
            <td>{{$item->delivery_time}}</td>
            <td>
                @if($item->item_status == '1')
                    <a class="badge badge-info px-2" onclick="StatusUpdate('{{$item->id}}','2')" style="color: #fff;">Available</a>
                @else
                    <a class="badge badge-primary px-2" onclick="StatusUpdate('{{$item->id}}','1')" style="color: #fff;">Unavailable</a>
                @endif
            </td>
            <td>
                <span>
                    <a href="#" data-toggle="tooltip" data-placement="top" onclick="GetData('{{$item->id}}')" title="" data-original-title="Edit">
                        <span class="badge badge-success">Edit</span>
                    </a>
                    <a data-toggle="tooltip" href="{{URL::to('admin/item-images/'.$item->id)}}" data-original-title="View">
                        <span class="badge badge-warning">View</span>
                    </a>
                </span>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>