<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
 <!-- Brand Logo -->
 <a class="brand-link">
   <span class="brand-text font-weight-light">Administrator</span>
 </a>
 <!-- Sidebar -->
 <div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
   <ul 
    class="nav nav-pills nav-sidebar flex-column" 
    data-widget="treeview" 
    role="menu" 
    data-accordion="false">
     <li class="nav-item">
       <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? ' active' : '' }}">
         <i class="fa fa-home nav-icon"></i>
         <p>ინფორმაცია</p>
        </a>       
     </li>
     <li class="nav-item menu-is-opening menu-open">
      <a href="#" class="nav-link">
       <i class="nav-icon fas fa-th"></i>
       <p>
         ძირითადი
       </p>
      </a>
      <ul class="nav nav-treeview">
       <li class="nav-item">
        <a href="{{ route('regions.list') }}" class="nav-link {{ Request::is('regions*') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
         <p>რეგიონი</p>
        </a>
       </li>
       <li class="nav-item">
        <a href="{{ route('municipalities.list') }}" class="nav-link {{ Request::is('municipalities*') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
         <p>მუნიციპალიტეტი</p>
        </a>
       </li>
       <li class="nav-item">
        <a href="{{ route('prioriteties.list') }}" class="nav-link {{ Request::is('prioriteties*') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
         <p>პრიორიტეტი</p>
        </a>
       </li>
       <li class="nav-item">
        <a href="{{ route('kindergartens.list') }}" class="nav-link {{ Request::is('kindergartens*') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
         <p>ბაღი</p>
        </a>
       </li>
       <li class="nav-item">
        <a href="{{ route('kindergarteners.index') }}" class="nav-link {{ Request::is('kindergarteners*') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
          <p>აღსაზრდელი</p>
         </a>
       </li>
      </ul>
     </li>
     <li class="nav-item menu-is-opening menu-open">
      <a href="#" class="nav-link">
       <i class="nav-icon fas fa-tachometer-alt"></i>
       <p>მართვა
       </p>
      </a>
      <ul class="nav nav-treeview">
       <li class="nav-item">
        <a href="{{ route('settings.index') }}" class="nav-link {{ Request::is('settings') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
         <p>პარამეტრები</p>
        </a>
       </li>
       <li class="nav-item">
        <a href="{{ route('settings.date') }}" class="nav-link {{ Request::is('settings/date') ? ' active' : '' }}">
         <i class="far fa-circle nav-icon"></i>
         <p>თარიღი</p>
        </a>
        @if (data_get($settings, 'basic.object.canPorting'))
        <form id="portireba" method="POST" action="{{ route('settings.learning') }}">
        @csrf
        <a style="background-color: red; color: white;cursor:pointer;" 
          data-submit="portireba" 
          data-message="პორტირება აუცილებლად უნდა შესრულდეს მხოლოდ სასწავლო წლის დასრულების შემდეგ ერთჯერადად!"
          data-title="ნამდვილად გსურთ პორტირების შესრულება?"
          onclick="nottify(event)" class="nav-link">
         <i class="far fa-circle nav-icon"></i>         
         <p>პორტირება</p>
        </a>
       </form>
       @else
         <a
          data-message="დროის ამ მომენტში პორტირება ნებადართული არ არის!"
          data-no-buttons="true"
          onclick="nottify(event)"
          class="nav-link" style="color:#ccc; cursor: pointer;"></i><i class="far fa-circle nav-icon"></i><p>პორტირება</p></a>
       @endif
       </li>
       <li class="nav-item">
         <a href="{{ route('users.list') }}" class="nav-link {{ Request::is('users*') ? ' active' : '' }}">
          <p>მომხმარებლები</p>
         </a>       
       </li>
      </ul>
     </li>
    </ul>
   </nav>
  <!-- /.sidebar-menu -->
 </div>
 <!-- /.sidebar -->
</aside>










