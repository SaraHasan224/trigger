@extends('layouts.admin')
@section('styles')
  <link rel="stylesheet" href="{{ asset("admin/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css") }}">
@endsection
@section("contents")
  <div class="viewport-header">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
          <a href="{{ route("admin-dashboard") }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Overview</li>
      </ol>
    </nav>
    <div class="content-viewport">
      <div class="row">
        <div class="col-md-5 order-md-0 order-md-2">
          <div class="row">
            <div class="col-6 equel-grid">
              <div class="grid d-flex flex-column align-items-center justify-content-center">
                <div class="grid-body text-center">
                  <div class="profile-img img-rounded bg-inverse-primary no-avatar component-flat mx-auto mb-4"><i class="mdi mdi-account-group mdi-2x"></i></div>
                  <h2 class="font-weight-medium"><span class="animated-count">21.2</span>k</h2>
                  <small class="text-gray d-block mt-3">Total Followers</small>
                  <small class="font-weight-medium text-success"><i class="mdi mdi-menu-up"></i><span class="animated-count">12.01</span>%</small>
                </div>
              </div>
            </div>
            <div class="col-6 equel-grid">
              <div class="grid d-flex flex-column align-items-center justify-content-center">
                <div class="grid-body text-center">
                  <div class="profile-img img-rounded bg-inverse-danger no-avatar component-flat mx-auto mb-4"><i class="mdi mdi-airballoon mdi-2x"></i></div>
                  <h2 class="font-weight-medium"><span class="animated-count">1.6</span>k</h2>
                  <small class="text-gray d-block mt-3">Impression</small>
                  <small class="font-weight-medium text-danger"><i class="mdi mdi-menu-down"></i><span class="animated-count">3.45</span>%</small>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6 equel-grid">
              <div class="grid d-flex flex-column align-items-center justify-content-center">
                <div class="grid-body text-center">
                  <div class="profile-img img-rounded bg-inverse-warning no-avatar component-flat mx-auto mb-4"><i class="mdi mdi-fire mdi-2x"></i></div>
                  <h2 class="font-weight-medium animated-count">2067</h2>
                  <small class="text-gray d-block mt-3">Reach</small>
                  <small class="font-weight-medium text-danger"><i class="mdi mdi-menu-down"></i><span class="animated-count">11.39</span>%</small>
                </div>
              </div>
            </div>
            <div class="col-6 equel-grid">
              <div class="grid d-flex flex-column align-items-center justify-content-center">
                <div class="grid-body text-center">
                  <div class="profile-img img-rounded bg-inverse-success no-avatar component-flat mx-auto mb-4"><i class="mdi mdi-charity mdi-2x"></i></div>
                  <h2 class="font-weight-medium"><span class="animated-count">20.7</span>%</h2>
                  <small class="text-gray d-block mt-3">Engagement Rate</small>
                  <small class="font-weight-medium text-success"><i class="mdi mdi-menu-up"></i><span class="animated-count">47.84</span>%</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-7 equel-grid ">
          <div class="grid d-flex flex-column justify-content-between overflow-hidden"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="grid-body">
              <div class="d-flex justify-content-between">
                <p class="card-title">Sales Revenue</p>
                <div class="chartjs-legend" id="sales-revenue-chart-legend"><ul class="0-legend"><li><span style="background-color:#1A76CA"></span>Sales</li><li><span style="background-color:#2d92fe"></span>Marketing</li></ul></div>
              </div>
              <div class="d-flex">
                <p class="d-none d-xl-block">12.5% Growth compared to the last week</p>
                <div class="ml-auto">
                  <h2 class="font-weight-medium text-gray"><i class="mdi mdi-menu-up text-success"></i><span class="animated-count">25.04</span>%</h2>
                </div>
              </div>
            </div>
            <canvas class="mt-4 chartjs-render-monitor" id="sales-revenue-chart" height="245" style="display: block;" width="570"></canvas>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 equel-grid">
          <div class="grid">
            <div class="grid-body py-3">
              <p class="card-title ml-n1">Search History</p>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-sm">
                <thead>
                <tr class="solid-header">
                  <th colspan="2" class="pl-4">Customer</th>
                  <th>Order No</th>
                  <th>Purchased On</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="pr-0 pl-4">
                    <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                  </td>
                  <td class="pl-md-0">
                    <small class="text-black font-weight-medium d-block">Barbara Curtis</small>
                    <span>
                              <span class="status-indicator rounded-indicator small bg-primary"></span>Account Deactivated </span>
                  </td>
                  <td>
                    <small>8523537435</small>
                  </td>
                  <td> Just Now </td>
                </tr>
                <tr>
                  <td class="pr-0 pl-4">
                    <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                  </td>
                  <td class="pl-md-0">
                    <small class="text-black font-weight-medium d-block">Charlie Hawkins</small>
                    <span>
                              <span class="status-indicator rounded-indicator small bg-success"></span>Email Verified </span>
                  </td>
                  <td>
                    <small>9537537436</small>
                  </td>
                  <td> Mar 04, 2018 11:37am </td>
                </tr>
                <tr>
                  <td class="pr-0 pl-4">
                    <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                  </td>
                  <td class="pl-md-0">
                    <small class="text-black font-weight-medium d-block">Nina Bates</small>
                    <span>
                              <span class="status-indicator rounded-indicator small bg-warning"></span>Payment On Hold </span>
                  </td>
                  <td>
                    <small>7533567437</small>
                  </td>
                  <td> Mar 13, 2018 9:41am </td>
                </tr>
                <tr>
                  <td class="pr-0 pl-4">
                    <img class="profile-img img-sm" src="http://www.placehold.it/50x50" alt="profile image">
                  </td>
                  <td class="pl-md-0">
                    <small class="text-black font-weight-medium d-block">Hester Richards</small>
                    <span>
                              <span class="status-indicator rounded-indicator small bg-success"></span>Email Verified </span>
                  </td>
                  <td>
                    <small>5673467743</small>
                  </td>
                  <td> Feb 21, 2018 8:34am </td>
                </tr>
                </tbody>
              </table>
            </div>
            <a class="border-top px-3 py-2 d-block text-gray" href="#"><small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i>View All Order History</small></a>
          </div>
        </div>
        <div class="col-md-4 equel-grid">

          <div class="grid">
            <div class="grid-body">
              <div class="d-flex justify-content-between">
                <p class="card-title">Activity Log</p>
                <div class="btn-group">
                  <button type="button" class="btn btn-trasnparent btn-xs component-flat pr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Expand View</a>
                    <a class="dropdown-item" href="#">Edit</a>
                  </div>
                </div>
              </div>
              <div class="vertical-timeline-wrapper">
                <div class="timeline-vertical dashboard-timeline">
                  <div class="activity-log">
                    <p class="log-name">Agnes Holt</p>
                    <div class="log-details">Analytics dashboard has been created<span class="text-primary ml-1">#Slack</span></div>
                    <small class="log-time">8 mins Ago</small>
                  </div>
                  <div class="activity-log">
                    <p class="log-name">Ronald Edwards</p>
                    <div class="log-details">Report has been updated <div class="grouped-images mt-1">
                        <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                        <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                        <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                        <img class="img-sm" src="http://www.placehold.it/50x50" alt="Profile Image">
                        <span class="plus-text img-sm">+3</span>
                      </div>
                    </div>
                    <small class="log-time">3 Hours Ago</small>
                  </div>
                  <div class="activity-log">
                    <p class="log-name">Charlie Newton</p>
                    <div class="log-details"> Approved your request <div class="wrapper mt-1">
                        <button type="button" class="btn btn-xs btn-primary">Approve</button>
                        <button type="button" class="btn btn-xs btn-inverse-primary">Reject</button>
                      </div>
                    </div>
                    <small class="log-time">2 Hours Ago</small>
                  </div>
                  <div class="activity-log">
                    <p class="log-name">Gussie Page</p>
                    <div class="log-details">Added new task: Slack home page</div>
                    <small class="log-time">4 Hours Ago</small>
                  </div>
                  <div class="activity-log">
                    <p class="log-name">Ina Mendoza</p>
                    <div class="log-details">Added new images</div>
                    <small class="log-time">8 Hours Ago</small>
                  </div>
                </div>
              </div>
            </div>
            <a class="border-top px-3 py-2 d-block text-gray" href="#"><small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i>View All</small></a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js_plugins')
  <script src="{{ asset('admin/assets/vendors/chartjs/chart.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
@endsection