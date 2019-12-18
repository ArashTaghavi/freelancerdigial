<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Model\CompanyMember;
use App\Models\Assessment;
use App\Models\AttachmentCompany;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyWorkSample;
use App\Models\Project;
use App\ReservedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    /**
     * @return Company[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $companies = Company::with('reviewed')->where('user_id', Auth::id())->get();
        return $companies;
    }

    public function getById($id)
    {
        return Company::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->handleValidate($request);
        $company = new Company();
        $company->user_id = Auth::id();
        if (!empty($request->profile_image)) {
            $company->fillImage($request);
        }

        $company->introduction = Session::get('upload_introduction')[0];
        $company->fill($request->except('profile_image'));
        $company->save();
        Session::forget('upload_introduction');
        return ['message' => 'اطلاعات با موفقیت ثبت شد.لطفا مدارک شرکت خود را بارگذاری نمایید.', 'id' => $company->id];

    }

    public function create_attachment($id)
    {

    }

    public function store_attachment(Request $request, $id)
    {
        $this->handleAttachmentValidate($request);
        $type = $request->type;
        $attachment = new AttachmentCompany();
        if ($type == AttachmentCompany::REGISTERED_AD)
            $attachment->title = 'آگهی ثبت';
        if ($type == AttachmentCompany::VALUE_ADDED)
            $attachment->title = 'ارزش افزوده';
        if ($type == AttachmentCompany::HONORS)
            $attachment->title = 'افتخارات';
        $attachment->description = $request->description;
        $attachment->company_id = $id;
        $attachment->type = $type;
        $attachment->attachment = json_encode(Session::get('upload_attachment'));
        $attachment->save();
        Session::forget('upload_attachment');
        return $this->check_attachment($id);
    }

    public function update_attachment(Request $request, AttachmentCompany $attachmentCompany)
    {
        $this->handleAttachmentValidate($request);
        $type = $request->type;
        if ($type == AttachmentCompany::REGISTERED_AD)
            $attachmentCompany->title = 'آگهی ثبت';
        if ($type == AttachmentCompany::VALUE_ADDED)
            $attachmentCompany->title = 'ارزش افزوده';
        if ($type == AttachmentCompany::HONORS)
            $attachmentCompany->title = 'افتخارات';
        $attachmentCompany->type = $type;
        $attachmentCompany->description = $request->description;
        if (Session::get('upload_attachment')) {
            $attachmentCompany->attachment = json_encode(Session::get('upload_attachment'));
        }
        $attachmentCompany->save();
        Session::forget('upload_attachment');

        return ['message' => __('messages.update_success')];
    }

    /**
     * @param $company_id
     * @return mixed
     */
    public function attachment_list($company_id)
    {
        $attachments = Company::with('attachments')
            ->where('id', $company_id)
            ->where('user_id', Auth::id())
            ->first();
        return $attachments;

    }

    public function getAttachmentById(AttachmentCompany $attachmentCompany)
    {
        return $attachmentCompany;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param Company $company
     * @return array
     */
    public function update(Request $request, Company $company)
    {
        $this->handleValidate($request);
        $company->fill($request->except('profile_image'));
        $this->handleChangeImage($request, $company);
        $company->introduction = Session::get('upload_introduction')[0];
        $company->save();
        Session::forget('upload_introduction');
        return ['message' => __('messages.save_success')];
    }

    public function attachment_update(Request $request, AttachmentCompany $attachmentCompany)
    {
        $attachmentCompany->description = $request->description;
        $file_attachment = $attachmentCompany->upload_dir . $attachmentCompany->id . '/' . $attachmentCompany->attachment;
        if ($file = $request->file('attachment')) {
            if (file_exists($file_attachment))
                unlink($file_attachment);
            $new_file_name = time() . '.' . $file->getClientOriginalExtension();
            $attachmentCompany->attachment = $new_file_name;
        }
        $attachmentCompany->save();
    }

    /**
     * @param Company $company
     * @return array
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $attachment_companies = AttachmentCompany::where('company_id', $company->id)->get();
        foreach ($attachment_companies as $attachment_company) {
            $file_address = public_path() . "/uploads/attachment-company/$company->id/$attachment_company->attachment";
            if (file_exists($file_address))
                unlink($file_address);
            $attachment_company->delete();
        }

        $company->delete();
        return ['message' => __('messages.delete_success')];
    }

    public function destroy_attachment(AttachmentCompany $attachmentCompany)
    {
        if (!empty($attachment = $attachmentCompany->attachment)) {
            $files = json_decode($attachment);
            foreach ($files as $file) {
                if (file_exists(public_path($file)))
                    unlink(public_path($file));
            }
        }
        $attachmentCompany->delete();
        return ['message' => __('messages.delete_success')];

    }

    public function destroy_attachment_single(AttachmentCompany $attachmentCompany)
    {
        $files = json_decode($attachmentCompany->attachment);
        foreach ($files as $key => $file) {
            if (!empty(request()->get('file'))) {
                $file = request()->get('file');
                if (file_exists(public_path($file))) {
                    unlink(public_path($file));
                    unset($files[$key]);
                    break;
                }
            }
        }
        $files = array_values($files);
        $attachmentCompany->attachment = json_encode($files);
        $attachmentCompany->save();
        return ['message' => __('messages.delete_success')];
    }

    /**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function handleValidate(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'address' => 'required',
            'member_count' => 'required',
            'activity_duration' => 'required',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function upload_attachment($id)
    {
        Session::forget('upload_attachment');
        $file = request()->file('file');

        $file_name = time() . '-' . $file->getClientOriginalName();
        $dir = "/uploads/company-attachment/{$id}";
        $file->move(public_path($dir), $file_name);
        Session::push('upload_attachment', "{$dir}/$file_name");
    }

    public function category_list()
    {
        return Category::where('active', 1)->get();
    }

    public function review($company_id)
    {
        return Company::with('reviewed', 'reviewed.details')->where('id', $company_id)->first();
    }

    public function attachment_type()
    {
        return [
            ['id' => AttachmentCompany::REGISTERED_AD, 'title' => 'آگهی ثبت'],
            ['id' => AttachmentCompany::VALUE_ADDED, 'title' => 'گواهی ارزش افزوده'],
            ['id' => AttachmentCompany::HONORS, 'title' => 'افتخارات']
        ];
    }

    public function work_sample_list($company_id)
    {
        $work_samples = Company::with('workSamples')
            ->where('id', $company_id)
            ->where('user_id', Auth::id())
            ->first();
        return $work_samples;
    }

    public function store_work_sample(Request $request, $id)
    {
        $this->handleWorkSampleValidate($request);
        $work_sample = new CompanyWorkSample();
        $work_sample->company_id = $id;
        $work_sample->fill($request->except('profile_image'));
        $work_sample->fillImage($request);
        $work_sample->save();
        return ['message' => __('messages.save_success')];
    }

    public function update_work_sample(Request $request, CompanyWorkSample $companyWorkSample)
    {
        $this->handleWorkSampleValidate($request);
        $companyWorkSample->fill($request->except('profile_image'));
        $this->handleChangeImage($request, $companyWorkSample);
        $companyWorkSample->save();
        return ['message' => __('messages.update_success')];
    }

    public function handleWorkSampleValidate(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function getWorkSampleById(CompanyWorkSample $companyWorkSample)
    {
        return $companyWorkSample;
    }

    public function destroy_work_sample(CompanyWorkSample $companyWorkSample)
    {
        $companyWorkSample->unlinkOriginalImage();
        $companyWorkSample->delete();
        return ['message' => __('messages.delete_success')];

    }

    public function upload_introduction()
    {
        Session::forget('upload_introduction');
        $file = request()->file('file');

        $file_name = time() . '-' . $file->getClientOriginalName();
        $dir = "/uploads/company-introduction";
        $file->move(public_path($dir), $file_name);
        Session::push('upload_introduction', "{$dir}/$file_name");
    }


    public function member_list($company_id)
    {
        $members = Company::with('members')
            ->where('id', $company_id)
            ->where('user_id', Auth::id())
            ->first();
        return $members;
    }


    public function store_member(Request $request, $id)
    {
        $this->handleMemberValidate($request);
        $member = new CompanyMember();
        $member->company_id = $id;
        $member->fill($request->except('profile_image'));
        $member->fillImage($request);
        $member->save();
        return ['message' => __('messages.save_success')];
    }


    public function update_member(Request $request, CompanyMember $companyMember)
    {
        $this->handleMemberValidate($request);
        $companyMember->fill($request->except('profile_image'));
        $this->handleChangeImage($request, $companyMember);
        $companyMember->save();
        return ['message' => __('messages.update_success')];
    }

    public function destroy_member(CompanyMember $companyMember)
    {
        $companyMember->unlinkOriginalImage();
        $companyMember->delete();
        return ['message' => __('messages.delete_success')];

    }

    public function getMemberById(CompanyMember $companyMember)
    {

        return $companyMember;
    }

    public function handleMemberValidate(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function handleChangeImage($request, $model)
    {
        if (empty($request->profile_image)) {
            if (!empty($model->profile_image)) {
                $model->unlinkOriginalImage();
            }
            $model->profile_image = NULL;
        } else {
            if ($request->profile_image != $model->profile_image) {
                $model->unlinkOriginalImage();
                $model->fillImage($request);
            }
        }
    }

    //For check that all attachment uploaded from each company
    public function check_attachment($company_id)
    {
        $attachment_1 = AttachmentCompany::where('company_id', $company_id)
            ->where('type', AttachmentCompany::REGISTERED_AD)->first();
        $attachment_2 = AttachmentCompany::where('company_id', $company_id)
            ->where('type', AttachmentCompany::VALUE_ADDED)->first();
        $attachment_3 = AttachmentCompany::where('company_id', $company_id)
            ->where('type', AttachmentCompany::HONORS)->first();

        if (!empty($attachment_1) && !empty($attachment_2) && !empty($attachment_3)) {
            return ['message' => 'مدارک با موفقیت بارگذاری شدند.لطفا نمونه کارهای خود را بارگذاری نمایید.', 'next' => true];

        } else {
            return ['message' => 'مدارک با موفقیت بارگذاری شدند.لطفا باقی مدارک را بارگذاری نمایید.', 'next' => false];
        }
    }

    public function get_assessment($id)
    {
        return Assessment::find($id)->title;
    }

    public function project($id)
    {
        return Project::where('user_id', Auth::id())
            ->where('company_id', $id)
            ->get();
    }

    public function reserved_projects($id)
    {
        return ReservedProject::with('project')
            ->where('user_id', Auth::id())
            ->where('company_id', $id)
            ->get();
    }

    public function handleAttachmentValidate(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'type' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

}
