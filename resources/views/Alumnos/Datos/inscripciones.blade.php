@extends('Alumnos.layout')

@section('content')

<main id="fondo-estudiantes">
    <section class="table">
      <div class="table__header">
        <h1>Inscripciones</h1>
      </div>
      <div class="table__body">
        <table>
          <thead>
            <tr>
              <th>Año</th>
              <th>Materia</th>
              <th>Hora</th>
              <th>Profesores</th>
              <th>Llamado 1</th>
              <th>Llamado 2</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            @foreach($materias as $materia)
              @php
                  
              $yaAnotado=false; 
              $sinMesas=false;
              
              if(count($materia->mesas) < 1)$sinMesas=true;
              else {
                  foreach($materia->mesas as $mesa){
                      if(in_array($mesa->id, $yaAnotadas)) $yaAnotado=$mesa;
                  }
              }

              $path = $yaAnotado? "alumno.bajarse":"alumno.inscribirse";
              $btnTexto = $yaAnotado? "desinscribirme":"inscribirme"; 
              
            @endphp

          @if (count($materia->mesas)<1)
            @continue
          @endif              

            <tr>
              <td>{{$materia->anio + 1}}</td>
              <td>{{$materia->nombre}}</td>
              <td>{{$materia->hora}}</td>
              <td>

                <p>{{
                    $materia->mesas[0]->prof_presidente? 
                      $textFormatService->utf8UpperCamelCase($materia->mesas[0]->profesor->nombre.' '.$materia->mesas[0]->profesor->apellido):
                      'A confirmar'
                }}</p>
                <p>{{
                    $materia->mesas[0]->vocal1? 
                      $textFormatService->utf8UpperCamelCase($materia->mesas[0]->vocal1->nombre.' '.$materia->mesas[0]->vocal1->apellido):
                      'A confirmar'
                }}</p>
                @if ($materia->mesas[0]->vocal2)
                    <p>{{$textFormatService->utf8UpperCamelCase($materia->mesas[0]->vocal2->nombre.' '.$materia->mesas[0]->vocal2->apellido)}}</p>
                @endif
              </td>
              
              @include('Componentes.inscripcion-form')
@endforeach

         
            
            
          </tbody>
        </table>
      </div>

    </section>
    
  </main>
    
</div>
    

@endsection
