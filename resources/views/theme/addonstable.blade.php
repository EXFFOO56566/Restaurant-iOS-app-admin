<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Item Name</th>
            <th>Addons Name</th>
            <th>Price</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($getaddons as $addons) {
        ?>
        <tr id="dataid{{$addons->id}}">
            <td>{{$addons->id}}</td>
            <td>{{$addons['category']->category_name}}</td>
            <td>{{$addons['item']->item_name}}</td>
            <td>{{$addons->name}}</td>
            <td>{{$addons->price}}</td>
            <td>{{$addons->created_at}}</td>
            <td>
                <span>
                    <a href="#" data-toggle="tooltip" data-placement="top" onclick="GetData('{{$addons->id}}')" title="" data-original-title="Edit">
                        <span class="badge badge-success">Edit</span>
                    </a>
                    @if($addons->is_available == '1')
                        <a class="badge badge-info px-2" onclick="StatusUpdate('{{$addons->id}}','2')" style="color: #fff;">Available</a>
                    @else
                        <a class="badge badge-primary px-2" onclick="StatusUpdate('{{$addons->id}}','1')" style="color: #fff;">Unavailable</a>
                    @endif
                </span>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>