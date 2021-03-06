  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
      <span class="brand-text font-weight-light">Question Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">John Doe</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @if(Auth::user()->category == 'admin')
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('questions.index')}}" class="nav-link {{Route::is('questions.*')?'active':''}}">
                        <span><i class="fas fa-question-circle"></i></span>
                        Questions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('questions-banks.index')}}" class="nav-link {{Route::is('questions-banks.*')?'active':''}}">
                        <span><i class="fas fa-book"></i></span>
                        Question Bank
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('exams.index')}}" class="nav-link {{Route::is('exams.*')?'active':''}}">
                        <span><i class="fas fa-book"></i></span>
                        Exams
                    </a>
                </li>
                @elseif(Auth::user()->category == 'student')
                <li class="nav-item">
                    <a href="{{route('student-exams.index')}}" class="nav-link {{Route::is('student-exams.*')?'active':''}}">
                        <span><i class="fas fa-book"></i></span>
                     Exams
                    </a>
                </li>
                @endif
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
