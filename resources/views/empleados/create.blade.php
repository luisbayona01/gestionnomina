
@section('template_title')
    {{ __('Create') }} Empleado
@endsection

<form method="POST"   role="form" enctype="multipart/form-data"  class="needs-validation" novalidate id="formcreateEmpleados">
                            @csrf

                            @include('empleados.form')

</form>
