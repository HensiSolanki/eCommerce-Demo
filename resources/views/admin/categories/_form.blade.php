<div class="row">
	<div class="col-md-6">
		<div class="form-group mb-3">
			<label>Category Name</label>
			<input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name"
				data-validation="required" value="{{ isset($result) ? $result['category_name'] : old('category_name') }}">
			@error('category_name')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group mb-3">
			<label>Category Slug</label>
			<input id="category_slug" type="text" class="form-control @error('category_slug') is-invalid @enderror" name="category_slug"
				data-validation="required" value="{{ isset($result) ? $result['category_slug'] : old('category_slug') }}">
			@error('category_slug')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
	</div>
	</div>
