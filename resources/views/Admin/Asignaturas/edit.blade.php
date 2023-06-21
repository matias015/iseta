@extends('Admin.template')

@section('content')
<div class="edit-form-container">
    <div>

        @if ($errors -> any())
            @foreach ($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        @endif


       <form method="post" action="{{route('admin.asignaturas.update', ['asignatura'=>$asignatura->id])}}">
        @csrf
        @method('put')

        <p>asignatura <input value="{{$asignatura->nombre}}" name="nombre"></p>
        <select name="id_carrera">
            @foreach($carreras as $carrera)
                <option @selected($carrera->id == $asignatura->id_carrera) value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>
        <p>tipo modulo <input value="{{$asignatura->tipo_modulo}}" name="tipo_modulo"></p>
        <p>carga horaria <input value="{{$asignatura->carga_horaria}}" name="carga_horaria"></p>
        <p>año<input value="{{$asignatura->anio}}" name="anio"></p>
        <p>observaciones <input value="{{$asignatura->observaciones}}" name="observaciones"></p>

        <p>correlativas</p>
        <ul>
            @foreach ($asignatura->correlativas as $correlativa)
                <li>- {{$correlativa->asignatura->nombre}}</li>
            @endforeach
        </ul>

        <input type="submit" value="Actualizar">
        </form>

        {{-- -------------------------- --}}
        <h2>Agregar correlativa</h2>
        
        <select name="carrera" id="carrera">
            @foreach ($carreras as $carrera)
                <option value="{{$carrera->id}}">{{$carrera->nombre}}</option>
            @endforeach
        </select>

       <form method="post" action="">
        @csrf

        <p>
            materia 
            <select class="asignatura" name="id_asignatura">
                <option value="">selecciona una carrera</option>
            </select>
        </p>
            <a href=""><button>Agregar</button></a>
        </form>
       
       
       <hr>
       <table>
        <tr>
            <td>imprimir</td>
            <td>nombre</td>
            <td>apellido</td>
            <td>dni</td>
            <td>acciones</td>
        </tr>

        <form enctype="multipart/form-data" action="{{route('test.print-1')}}">
            alumnos que cursan esta materia que aun no tienen un estado final (aprobado o desaprobado)
        @foreach ($alumnos as $alumno)
            <tr>
                <td><input type="checkbox" checked name="toPrint[]" value="{{$alumno->id}}"></td>
                
                <td> {{$alumno->nombre}} </td>

                <td> {{$alumno->apellido}} </td>

                <td> {{$alumno->dni}} horas</td>

                <td style="display:flex;">
                    {{-- <form action="">
                        <button>Editar</button>
                    </form>
                    <form action="">
                        <button>Eliminar</button>
                    </form> --}}
                    <a href="{{route('admin.cursadas.edit', ['cursada' => $alumno->cursada_id])}}">Editar cursada</a>
                </td>
            </tr>
        @endforeach

            

       </table>
       <input type="submit" value="Imprimir">
    </form>
    </div>
</div>

<script>
    const carrera = document.querySelector('#carrera')
    const asignaturaSelect = document.querySelector('.asignatura')
    carrera.addEventListener('change',function(){
        asignaturaSelect.innerHTML = '';
        fetch(`http://127.0.0.1:8000/api/a/${carrera.value}`)
            .then( data => data.json())
            .then(data=>{
                data.forEach(element => {
                    const option = document.createElement('option')
                    option.value = element.id
                    option.textContent = element.nombre
                    asignaturaSelect.appendChild(option)
                });
                
            })
    })
</script>
@endsection