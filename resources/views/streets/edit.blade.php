<div class="modal fade" id="editStreet{{$street->id}}" tabindex="-1" role="dialog" aria-labelledby="addbStreetData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Street</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{url('update_street/'.$street->id)}}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{$street->name}}">
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Barangay</label>
                            <select name="barangay_id" id="barangay" class="form-control select2" required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $b)
                                    <option value="{{ $b->id }}" @if($street->barangay_id == $b->id) selected @endif>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div> 
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select Barangay',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#formStreet') 
        });
    });
</script>