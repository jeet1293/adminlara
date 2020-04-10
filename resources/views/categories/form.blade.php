<div class="card-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {!! Form::label('title', 'Title'); !!}
                {!! Form::text('title', optional($category)->title, ['class' => 'form-control', 'id' => 'title']); !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {!! Form::label('status', 'Status'); !!}
                {!! Form::select('status', [true => 'Active', false => 'InActive'],optional($category)->status,['class' => 'form-control', 'placeholder' => 'Select Status']); !!}
            </div>
        </div>
    </div>
    

    
    
</div>
<!-- /.card-body -->
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>