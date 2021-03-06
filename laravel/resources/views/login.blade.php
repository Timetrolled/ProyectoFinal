<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">






<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Acceder</h4>
	<form method="POST" action="/login">
	{{ csrf_field() }}
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email" type="email" value="{{old('email')}}">
    <div class="form-group input-group mt-3">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" class="form-control" placeholder="Contraseña" type="password">
    </div> <!-- form-group// -->                                  
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block mp-2"> Acceder  </button>
        <p class="text-center ms-2">¿No estás registrado aún? <a href="/register">Crear cuenta  </a> </p>                                                                 
    </div> <!-- form-group// -->      
	@if (count($errors) > 0)
		<div class="error">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
</form>
</article>
</div> <!-- card.// -->

</div> 
<!--container end.//-->
</article>