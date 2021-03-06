		<nav class="navbar navbar-default misection">
		    @if ($categorias->count()>8)
		    <div class="container-fluid">
		        @else
		        <div class="container">
		            @endif
		            <div class="navbar-header">
		                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		                    <span class="sr-only">Toggle navigation</span>
		                    <span>Ver Categorias</span>
		                </button>
		            </div>

		            <!-- Collect the nav links, forms, and other content for toggling -->
		            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		                <ul class="nav navbar-nav navbar-center">
		                    <li class="nav-item">
		                        <a href="{{ route('inicio.tienda') }}" class="nav-link active">Inicio</a>
		                    </li>
		                    @foreach ($categorias as $item)
		                    @if ($item->marcas->count()<=1) <li class="nav-item">
		                        <a href="{{ route('filtro.categoria',  $item->nombre_categoria) }}" class="nav-link active">{{ $item->nombre_categoria }}</a>
		                        </li>
		                        @else
		                        @if ($item->marcas->count()==3)
		                        <li class="dropdown menu-large">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item->nombre_categoria }} <span class="caret"></span></a>
		                            <ul class="dropdown-menu megamenu row animate__animated animate__fadeIn">
		                                @foreach ($item->marcas as $marcas)
		                                <li class="col-sm-4">
		                                    <ul>
		                                        <li class="dropdown-header">{{ $marcas->nombre_marca }}</li>
		                                        @foreach ($marcas->submarca as $item)
		                                        <li><a href="{{ route('filtro.marca',  $item) }}">{{ $item->nombre_submarca }}</a></li>
		                                        @endforeach
		                                        <br>
		                                    </ul>
		                                </li>
		                                @endforeach
		                            </ul>
		                        </li>
		                        @else
		                        @if ($item->marcas->count()==4)
		                        <li class="dropdown menu-large">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item->nombre_categoria }} <span class="caret"></span></a>
		                            <ul class="dropdown-menu megamenu row animate__animated animate__fadeIn">
		                                @foreach ($item->marcas as $marcas)
		                                <li class="col-sm-3">
		                                    <ul>
		                                        <li class="dropdown-header">{{ $marcas->nombre_marca }}</li>
		                                        @foreach ($marcas->submarca as $item)
		                                        <li><a href="{{ route('filtro.marca',  $item) }}">{{ $item->nombre_submarca }}</a></li>
		                                        @endforeach
		                                        <br>
		                                    </ul>
		                                </li>
		                                @endforeach
		                            </ul>
		                        </li>
		                        @else
		                        @if ($item->marcas->count()>4)
		                        <li class="dropdown menu-large">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item->nombre_categoria }} <span class="caret"></span></a>
		                            <ul class="dropdown-menu megamenu row animate__animated animate__fadeIn">
		                                @foreach ($item->marcas as $marcas)
		                                <li class="col-sm-2">
		                                    <ul>
		                                        <li class="dropdown-header">{{ $marcas->nombre_marca }}</li>
		                                        @foreach ($marcas->submarca as $item)
		                                        <li><a href="{{ route('filtro.marca',  $item) }}">{{ $item->nombre_submarca }}</a></li>
		                                        @endforeach
		                                        <br>
		                                    </ul>
		                                </li>
		                                @endforeach
		                            </ul>
		                        </li>
		                        @endif
		                        @endif
		                        @endif
		                        @endif
		                        @endforeach
		                </ul>
		            </div><!-- /.navbar-collapse -->
		        </div><!-- /.container-fluid -->
		</nav>
