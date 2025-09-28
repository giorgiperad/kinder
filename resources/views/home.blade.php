@extends('layouts.app')

@section('content')
<div class="content-header">
      <div class="container-fluid">
       <div class="row mb-2">
        <div class="col-sm-6">
         <h1 class="m-0">ზოგადი ინფორმაცია</h1>
        </div><!-- /.col -->
       </div><!-- /.row -->
      </div><!-- /.container-fluid -->
     </div>
    <section class="content">
        <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$user_count}}</h3>

                <p>მომხმარებელი</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">დეტალურად <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$municipality_count}}</h3>

                <p>მუნიციპალიტეტი</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ route('municipalities.list') }}" class="small-box-footer">დეტალურად <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$kindergartner_count}}</h3>

                <p>ბავშვი</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('kindergarteners.index') }}" class="small-box-footer">დეტალურად <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$kindergarten_count}}</h3>

                <p>ბაღი</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ route('kindergartens.list') }}" class="small-box-footer">დეტალურად <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="table-responsive">
            <table class="table">
              <tbody>
              <tr>
                <th>სწავლის სტატუსი:</th>
                <td>{{data_get($basic, 'object.isLearningStart') ? 'მიმდინარე' : 'დასრულებული'}}</td>
              </tr>
              <tr>
                <th>სწავლის დაწყების დრო:</th>
                <td>{{data_get($date, 'object.start')}}</td>
              </tr>
              <tr>
                <th>სწავლის დასრულების დრო:</th>
                <td>{{data_get($date, 'object.end')}}</td>
              </tr>
              <tr>
                <th>პორტირების ნებართვა:</th>
                <td><span class="badge badge-primary">{{data_get($basic, 'object.canPorting') ? 'დიახ' : 'არა'}}</span></td>
              </tr>
              <tr>
                <th><a href="{{ route('kindergarteners.export') }}" style="color:green;">აღსაზრდელების ცხრილის ექსელი</a></th>
                <td></td>
              </tr>
            </tbody></table>
          </div>
        <!-- /.row (main row) -->
      </div>
    </section>
@endsection









