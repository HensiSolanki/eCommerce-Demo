<div class="row">
	<div class="col-md-6">
		<div class="form-group mb-3">
			<label>Product Name</label>
			<input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name"
				data-validation="required" value="{{ isset($result) ? $result['product_name'] : old('product_name') }}">
			@error('product_name')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group mb-3">
			<label>Description</label>
			<textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
				data-validation="required" value="{{ isset($result) ? $result['description'] : old('description') }}">{{ isset($result) ? $result['description'] : '' }}</textarea>
			@error('description')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
    <div class="col-md-6">
		<div class="form-group mb-3">
			<label></label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" aria-label="Default select example">
                <option value="">{{ isset($result) ? $result['category_name'] : 'Select Category' }}</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
			@error('category_id')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
    <div class="col-md-6">
		<div class="form-group mb-3">
			<label>Price</label>
			<input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price"
				data-validation="required" value="{{ isset($result) ? $result['price'] : old('price') }}">
			@error('price')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group mb-3">
			<label>Images</label>
            <input type="file" name="images[]" multiple class="form-control" accept="image/*">
			@error('images')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
	</div>
