<nav class="navbar fixed-bottom navbar-expand-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link"  href="{{ route('home') }}">
            <span class="material-icons">
              house
              </span>
            <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link"  href="{{ url('/auth/usuarios') }}">
            <span class="material-icons">
              fingerprint
              </span>
            <span class="sr-only">(current)</span></a>
        </li>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" onclick="event.preventDefault(); 
            document.getElementById('logout-form').submit();" href="{{ route('logout') }}">
            <span class="material-icons">
              cancel
              </span>
          </a>
          </div>
          <form id="logout-form" action="{{route('logout')}}" method="POST" style="display:none;">
            {{ csrf_field() }}
          </form>
        </div>
      </ul>
    </div>
  </nav>