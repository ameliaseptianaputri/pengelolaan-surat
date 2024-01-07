@extends('layouts.template')

@section('content')
<form class="row g-3 needs-validation" novalidate action="{{ route('surat.store') }}" method="POST">
    @csrf
    @if(Session::get('success'))
    <div class="alert alert-success"> {{ Session::get('success') }} </div>
    @endif
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    
    <div class="mb-3">
        <label for="letter_perihal" class="form-label">Perihal</label>
        <input type="text" class="form-control" id="letter_perihal" name="letter_perihal" aria-describedby="inputGroupPrepend" required>
        <div class="invalid-feedback">
            Please provide a perihal.
        </div>
    </div>

    <div class="mb-3">
        <label for="letter_type_id" class="form-label">Klasifikasi Surat</label>
        <select class="form-select" id="letter_type_id"  name="letter_type_id" aria-describedby="inputGroupPrepend" required>
            <option value="" hidden>Choose...</option>
            @foreach ($data as $item)
            <option value="{{ $item->id }}">{{ $item->nama_type }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Please choose a klasifikasi surat.
        </div>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Isi Surat</label>
        <textarea class="form-control" id="des" name="content" required></textarea>
        <div class="invalid-feedback">
            Please provide a isi surat.
        </div>
    </div>
    
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th scope="col">Nama</th>
          <th scope="col">Peserta (ceklist jika "ya")</th>
        </tr>
      </thead>
      <tbody>
        
    @foreach($guru as $gurs)
        <tr>
            <td>{{ $gurs->name }}</td>
            <td><input type="checkbox" name="recipients[]" value="{{ $gurs->id }}"></td>
        </tr>
    @endforeach
      </tbody>
    </table>

    <div class="md-3">
        <label for="attachment" class="form-label">Lampiran</label>
        <div class="input-group has-validation">
            <input type="file" class="form-control" id="attachment" name="attachment" aria-describedby="inputGroupPrepend">
        </div>
    </div>
    
    <div class="md-3">
        <label for="notulis" class="form-label">Notulis</label>
        <select class="form-select" id="notulis" name="notulis" required>
            <option value="" hidden>Choose...</option>
            <!-- Fetch data from Data Guru for Notulis options -->
            @foreach($guru as $gurs)
                <option value="{{ $gurs->id }}">{{ $gurs->name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Please select a notulis.
        </div>
    </div>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
    <script>
        ClassicEditor
        .create(document.querySelector('#des'))
        .catch(error => {
            console.error(error)
        });
    </script>
</form>

<script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection
