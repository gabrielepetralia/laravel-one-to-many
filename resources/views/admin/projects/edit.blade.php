@extends('layouts.admin')

@section('title')
  | Edit Project : {{ $project->name }}
@endsection

@section('content')
<div class="container">
  <h2 class="fs-4 my-4">Edit Project : {{ $project->name }}</h2>

  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="bg-dark rounded-3 p-4 mb-4">
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="name" class="form-label text-white fw-semibold">Name : <span class="text-danger">*</span></label>
        <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Project Name" type="text" value="{{ old('name', $project->name) }}">

        @error('name')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
        <label for="description" class="form-label text-white fw-semibold">Description : </label>
        <textarea class="form-control text-danger" name="description" id="description" cols="30" rows="10" placeholder="Project Description">{{ old('description', $project->description) }}</textarea>
      </div>

      <div class="mb-3">
        <label for="type_id" class="form-label text-white fw-semibold">Type : </label>
        <select class="form-select w-25" name="type_id">
          <option selected value="">Select project type</option>

          @foreach ($types as $type)
            <option value="{{ $type->id }}" @if( $type->id == old('type_id', $project?->type?->id) ) selected @endif>{{ $type->name }}</option>
          @endforeach

        </select>
      </div>

      <div class="mb-3">
        <label for="img" class="form-label text-white fw-semibold">Image : </label>
        <input
          class="form-control w-25"
          type="file"
          name="img"
          onchange="showImg(event)"
          value="{{ old('img', $project->img_original_name) }}">
        <img src="{{ asset('storage/' . $project->img_path) }}" id="img" width="250" alt="{{ $project->img_original_name }}" class="mt-3" onerror="this.src='/img/noimage.png'">
      </div>

      <div class="mb-3">
        <label for="is_finished" class="form-label text-white fw-semibold">Is Finished : </label>
        <input
          class="form-check-input"
          type="checkbox"
          value="1"
          @if ( (old('is_finished') == 1) || ($project->is_finished == 1) ) checked @endif
          id="is_finished"
          name="is_finished">
      </div>

      <div class="mb-3">
        <label for="start_date" class="form-label text-white fw-semibold">Start Date : <span class="text-danger">*</span></label>
        <input id="start_date" class="form-control w-25 @error('start_date') is-invalid @enderror" name="start_date" type="date" value="{{ old('start_date', $project->start_date) }}">

        @error('start_date')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-3">
          <label for="end_date" class="form-label text-white fw-semibold">End Date : </label>
          <input id="end_date" class="form-control w-25" name="end_date" type="date" value="{{ old('end_date', $project->end_date) }}">
      </div>

      <div class="d-flex justify-content-between">
        <div>
          <a href="{{ route('admin.projects.index')}}" title="Go back" class="btn btn-primary text-white"><i class="fa-solid fa-left-long"></i></a>
        </div>

        <button type="submit" class="btn btn-success text-white" title="Edit"><i class="fa-solid fa-floppy-disk"></i></button>
      </div>

    </form>
  </div>


</div>

<script>
  ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
      console.error( error );
    } );

    function showImg(event){
      const tagImage = document.getElementById('img');
      tagImage.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

@endsection
