<div class="d-flex align-items-stretch main-sidebar">
    <div id="sidebar" class="sidebar py-3">

        @if (Auth::user()->role == 'admin')
            <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-2 font-weight-bold small headings-font-family">
                SETUP
            </div>
            <ul class="sidebar-menu list-unstyled">
                <li class="sidebar-list-item">
                    <a href="{{ route('users') }}"
                       class="sidebar-link text-muted">
                        <i class="fa fa-users text-gray"></i><span>Users</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="{{ route('institutes') }}"
                       class="sidebar-link text-muted">
                        <i class="fa fa-university text-gray"></i><span>Institute</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="{{ route('course_types') }}"
                       class="sidebar-link text-muted">
                        <i class="fa fa-list-alt text-gray"></i><span>Sector</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="{{ route('courses') }}"
                       class="sidebar-link text-muted">
                        <i class="fa fa-book text-gray"></i><span>Course</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="{{ route('batches') }}"
                       class="sidebar-link text-muted">
                        <i class="fa fa-users text-gray"></i><span>Batch</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="javascript:void(0)" data-toggle="collapse"
                       data-target="#teacher_menu"
                       aria-expanded="false"
                       aria-controls="teacher_menu"
                       class="sidebar-link text-muted"><i
                                class="fa fa-user-plus text-gray"></i><span>Teacher</span></a>
                    <div id="teacher_menu" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="sidebar-list-item">
                                <a href="{{ route('teachers.find') }}"
                                   class="sidebar-link text-muted">
                                    <i class="fas fa-chalkboard-teacher text-gray"></i><span>Teacher Info</span>
                                </a>
                            </li>
                            <li class="sidebar-list-item">
                                <a href="{{ route('teacher.payment.setup.index') }}"
                                   class="sidebar-link text-muted ">
                                    <i class="fa fa-money-bill-wave
                                text-gray"></i><span>Payment Setup</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-list-item">
                    <a href="javascript:void(0)" data-toggle="collapse"
                       data-target="#mentor_menu"
                       aria-expanded="false"
                       aria-controls="mentor_menu"
                       class="sidebar-link text-muted"><i
                                class="fa fa-user-plus text-gray"></i><span>Mentor</span></a>
                    <div id="mentor_menu" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="sidebar-list-item">
                                <a href="{{ route('mentors') }}"
                                   class="sidebar-link text-muted">
                                    <i class="fas fa-chalkboard-teacher text-gray"></i><span>Mentor</span>
                                </a>
                            </li>
                            <li class="sidebar-list-item">
                                <a href="{{ route('mentor.batch-setup.index') }}"
                                   class="sidebar-link text-muted ">
                                    <i class="fa fa-users text-gray"></i><span>Batch Setup</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        @endif

        <div class="text-gray-400 text-uppercase px-3 px-lg-4 py-2 font-weight-bold small headings-font-family">
            MAIN
        </div>
        <ul class="sidebar-menu list-unstyled">
            <li class="sidebar-list-item">
                <a href="{{ route('home') }}"
                   class="sidebar-link text-muted">
                    <i class="o-home-1 text-gray"></i><span>Home</span>
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="javascript:void(0)" data-toggle="collapse"
                   data-target="#admission"
                   aria-expanded="false"
                   aria-controls="admission"
                   class="sidebar-link text-muted"><i
                            class="fa fa-user-plus text-gray"></i><span>Admission</span></a>
                <div id="admission" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item">
                            <a href="{{ route('student.create') }}"
                               class="sidebar-link text-muted">
                                <i class="fa fa-info-circle
                                text-gray"></i><span>Student Info</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{ route('student.search') }}"
                               class="sidebar-link text-muted ">
                                <i class="fa fa-book
                                text-gray"></i><span>Course Info</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-list-item">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#student_info" aria-expanded="false"
                   aria-controls="student_info" class="sidebar-link
                   text-muted"><i class="fas fa-user-graduate text-gray"></i><span>Students</span></a>
                <div id="student_info" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item">
                            <a href="{{ route('students', 'professional') }}"
                               class="sidebar-link text-muted ">
                                <i class="fa fa-list
                                text-gray"></i><span>Professional</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{ route('students', 'industrial') }}"
                               class="sidebar-link text-muted">
                                <i class="fa fa-list
                                text-gray"></i><span>Industrial</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-list-item">
                <a href="{{ route('account') }}"
                   class="sidebar-link text-muted ">
                    <i class="fa fa-money-bill-alt
                    text-gray"></i><span>Payment</span>
                </a>
            </li>








            @if (Auth::user()->role == 'user')

            <li class="sidebar-list-item">
                <a href="{{ route('daily.report') }}"
                    class="sidebar-link text-muted ">
                    <i class="fa fa-file text-gray"></i><span>Daily report</span>
                </a>
            </li>
            @endif






            @if (Auth::user()->role == 'admin')

                <li class="sidebar-list-item">
                    <a href="{{ route('transaction') }}"
                       class="sidebar-link text-muted ">
                        <i class="fa fa-money-bill text-gray"></i><span>Transaction</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="{{ route('installment_dates.today') }}"
                       class="sidebar-link text-muted ">
                        <i class="fa fa-calendar-check text-gray"></i><span>Installment Dates</span>
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="javascript:void(0)" data-toggle="collapse" data-target="#teacher_payment"
                       aria-expanded="false"
                       aria-controls="teacher_payment" class="sidebar-link
                   text-muted"><i class="fas fa-money-check text-gray"></i><span>Teacher Payment</span></a>
                    <div id="teacher_payment" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="sidebar-list-item">
                                <a href="{{ route('teacher.payment.institute') }}"
                                   class="sidebar-link text-muted ">
                                    <i class="fa fa-money-check text-gray"></i><span>Payment</span>
                                </a>
                            </li>
                            <li class="sidebar-list-item">
                                <a href="{{ route('teacher.payment.history') }}"
                                   class="sidebar-link text-muted">
                                    <i class="fa fa-list-ol text-gray"></i><span>History</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-list-item">
                    <a href="javascript:void(0)" data-toggle="collapse" data-target="#mentor_payment"
                       aria-expanded="false"
                       aria-controls="mentor_payment" class="sidebar-link
                   text-muted"><i class="fas fa-money-check text-gray"></i><span>Mentor Payment</span></a>
                    <div id="mentor_payment" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="sidebar-list-item">
                                <a href="{{ route('mentor.payment.mentor-search') }}"
                                   class="sidebar-link text-muted ">
                                    <i class="fa fa-money-check text-gray"></i><span>Payment</span>
                                </a>
                            </li>
                            <li class="sidebar-list-item">
                                <a href="{{ route('mentor.payment.history') }}"
                                   class="sidebar-link text-muted">
                                    <i class="fa fa-list-ol text-gray"></i><span>History</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-list-item">
                    <a href="{{route('birthday')}}"
                       class="sidebar-link text-muted ">
                        <i class="fa fa-birthday-cake text-gray"></i><span>Birth Day</span>
                    </a>
                </li>











                <li class="sidebar-list-item">
                    <a href="javascript:void(0)" data-toggle="collapse" data-target="#report"
                       aria-expanded="false"
                       aria-controls="report" class="sidebar-link
                   text-muted">
                   <i class="fas fa-book text-gray"></i><span>Report</span></a>
                    <div id="report" class="collapse">
                        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                            <li class="sidebar-list-item">
                                <a href="{{ route('daily.report') }}"
                                   class="sidebar-link text-muted ">
                                    <i class="far fa-id-badge text-gray"></i><span>Daily report</span>
                                </a>
                            </li>
                            <li class="sidebar-list-item">
                                <a href="{{route('report.index')}}"
                                   class="sidebar-link text-muted">
                                    <i class="fa fa-file text-gray"></i><span>General Report</span>
                                </a>
                            </li>
                            <li class="sidebar-list-item">
                                 <a href="{{route('summary_report')}}"
                                   class="sidebar-link text-muted ">
                                    <i class="fa fa-list-alt" aria-hidden="true"></i><span>Summary Report</span>
                                 </a>
                            </li>
                            <li class="sidebar-list-item">
                                <a href="{{route('indivisual_report')}}"
                                  class="sidebar-link text-muted ">
                                  <i class="fas fa-user-friends"></i><span>Indivisual Report</span>
                                </a>
                           </li>

                        </ul>
                    </div>
                </li>


















            @endif

            <li class="sidebar-list-item">
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#marketing"
                   aria-expanded="false"
                   aria-controls="mentor_payment" class="sidebar-link
                   text-muted"><i class="fas fa-bullhorn text-gray"></i><span>Marketing</span></a>
                <div id="marketing" class="collapse">
                    <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
                        <li class="sidebar-list-item">
                            <a href="{{route('marketing.list.today')}}"
                               class="sidebar-link text-muted ">
                                <i class="fas fa-minus text-gray"></i><span>Today</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{route('marketing.list')}}"
                               class="sidebar-link text-muted ">
                                <i class="fas fa-minus text-gray"></i><span>Default List</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{route('marketing.add')}}"
                               class="sidebar-link text-muted">
                                <i class="fas fa-minus text-gray"></i><span>Add</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{route('marketing.admitted.list')}}"
                               class="sidebar-link text-muted">
                                <i class="fas fa-minus text-gray"></i><span>Admitted List</span>
                            </a>
                        </li>
                        <li class="sidebar-list-item">
                            <a href="{{route('marketing.not.interested.list')}}"
                               class="sidebar-link text-muted">
                                <i class="fas fa-minus text-gray"></i><span>Not Interested List</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
            <section class="py-5">

                @yield('content')

            </section>
        </div>
        <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
            <div class="container-fluid">
                <div class="text-center text-primary">
                    <p class="mb-2 mb-md-0 text-center">
                        <a href="https://euitsols.com" target="_blank">
                            Copyright &copy; European IT Solutions |
                            2009-{{ date('Y') }}
                        </a>
                    </p>
                </div>
            </div>
        </footer>
    </div>
</div>
