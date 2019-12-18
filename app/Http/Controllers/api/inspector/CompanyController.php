<?php

namespace App\Http\Controllers\api\inspector;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AttachmentCompany;
use App\Models\Company;
use App\Models\DetailReviewedCompany;
use App\Models\ReviewedCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Description;
use Psy\Util\Str;

class CompanyController extends Controller
{
    /**
     * @return Company[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Company::with('reviewed')->get();
    }

    public function getById($id)
    {
        return Company::with('attachments')
            ->with('reviewed', 'reviewed.details')
            ->with('members')
            ->with('workSamples')
            ->where('id', $id)->first();
    }

    public function store_review(Request $request, $company_id)
    {
        $this->handleReviewValidate($request);
        $review = ReviewedCompany::where('company_id', $company_id)->first();
        if (!empty($review)) {
            $review->fill($request->all());
        } else {
            $review = new ReviewedCompany();
            $review->fill($request->all());
        }
        $review->user_id = Auth::id();
        $review->company_id = $company_id;
        $review->save();
        DetailReviewedCompany::where('reviewed_company_id', $review->id)->delete();
        if (is_array($request->scores)) {
            foreach ($request->scores as $type => $score) {
                $detail = new DetailReviewedCompany();
                $detail->reviewed_company_id = $review->id;
                $detail->score = $score;
                $detail->type = $type;
                $detail->save();
            }
        }
        $average_score = DetailReviewedCompany::where('reviewed_company_id', $review->id)->average('score');
        $review->star = $average_score;
        $review->save();

        return ['message' => __('messages.save_success')];
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
        $company->fill($request->except('profile_image'));
        $company->save();
        return ['message' => __('messages.save_success')];

    }

    public function create_attachment($id)
    {

    }

    public function store_attachment(Request $request, $id)
    {
        session_start();
        $attachment = new AttachmentCompany();
        $attachment->title = $request->title;
        $attachment->description = $request->description;
        $attachment->company_id = $id;
        $attachment->attachment = json_encode($_SESSION['upload_attachment']);
        $attachment->save();
        unset($_SESSION['upload_attachment']);

        return ['message' => __('messages.save_success')];
    }

    public function update_attachment(Request $request, AttachmentCompany $attachmentCompany)
    {
        $attachmentCompany->title = $request->title;
        $attachmentCompany->description = $request->description;
        $attachmentCompany->attachment = json_encode($_SESSION['upload_attachment']);
        $attachmentCompany->save();
        unset($_SESSION['upload_attachment']);
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
        if ($this->handleValidate($request)) {
            if (!empty($request->profile_image)) {
                $company->fillImage($request);
            }
            $company->fill($request->except('profile_image'));
            $company->save();
        }
        return ['message' => __('messages.save_success')];
    }

    public function attachment_update(Request $request, AttachmentCompany $attachmentCompany)
    {
        /*$this->validate($request, ['description' => 'required']);*/
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
            if ($file == request()->get('file')) {
                if (file_exists(public_path($file)))
                    unlink(public_path($file));
                unset($files[$key]);
            }
        }
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
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function handleReviewValidate(Request $request)
    {
        $validator = \Validator::make($request->all(), ['description' => 'required']);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
        return $validator->getData();
    }

    public function upload_attachment($id)
    {
        session_start();
        $file = request()->file('file');

        $file_name = time() . '-' . $file->getClientOriginalName();
        $dir = "/uploads/company-attachment/{$id}";
        $file->move(public_path($dir), $file_name);
        $_SESSION['upload_attachment'][] = "{$dir}/$file_name";
    }

    public function assessment_list()
    {
        return Assessment::where('active', true)->get();
    }
}
