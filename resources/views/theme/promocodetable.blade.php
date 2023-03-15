<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Offer Name</th>
            <th>Offer Code</th>
            <th>Offer in percentage (%) </th>
            <th>Description </th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($getpromocode as $promocode) {
        ?>
        <tr id="dataid{{$promocode->id}}">
            <td>{{$promocode->id}}</td>
            <td>{{$promocode->offer_name}}</td>
            <td>{{$promocode->offer_code}}</td>
            <td>{{$promocode->offer_amount}}</td>
            <td>{{$promocode->description}}</td>
            <td>{{$promocode->created_at}}</td>
            <td>
                <span>
                    <a href="#" data-toggle="tooltip" data-placement="top" onclick="GetData('{{$promocode->id}}')" title="" data-original-title="Edit">
                        <span class="badge badge-success">Edit</span>
                    </a>
                    @if($promocode->is_available == '1')
                        <a class="badge badge-info px-2" onclick="StatusUpdate('{{$promocode->id}}','2')" style="color: #fff;">Available</a>
                    @else
                        <a class="badge badge-primary px-2" onclick="StatusUpdate('{{$promocode->id}}','1')" style="color: #fff;">Unavailable</a>
                    @endif
                </span>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>