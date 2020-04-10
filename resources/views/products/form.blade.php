<div class="card-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                {!! Form::label('category', 'Category'); !!}
                {!! Form::select('category_id[]', $categories,optional($product)->category_id,['multiple' => 'multiple', 'class' => 'select2 form-control', 'data-placeholder' => 'Select Category']); !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {!! Form::label('title', 'Title'); !!}
                {!! Form::text('title', optional($product)->title, ['class' => 'form-control', 'id' => 'title']); !!}
            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-6">
            <div class="form-group">
                {!! Form::label('status', 'Status'); !!}
                {!! Form::select('status', [true => 'Active', false => 'InActive'],optional($product)->status,['class' => 'form-control', 'placeholder' => 'Select Status']); !!}
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                {!! Form::label('image', 'Image'); !!}
                <div class="input-group">
                    <input type="file" name="image" accept="image/*" class="dropify" data-max-file-size="2M" data-show-remove="false" data-allowed-file-extensions="png jpg jpeg" data-default-file="{{ !empty($product) ? asset('uploads/products/'.$product->image) : '' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="row">   
        <div class="col-12">
            {!! Form::label('description', 'Description'); !!}
            {!! Form::textarea('description', optional($product)->description,['class' => 'form-control textarea', 'placeholder' => 'Select Status']); !!}
        </div>
    </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>