<?php

namespace App\Traits\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait RecruitmentSettings
{

    public function recruitment()
    {
        $data = [];
        $rec = $this->get_records(array_keys($this->recruitmentFields()));
        return view('setup.recruitment', compact('data', 'rec'));
    }

    public function updateRecruitment(Request $request)
    {
        if (empty($request->disable_writer_signup)) {
            $validator = Validator::make($request->all(), $this->recruitmentFields());

            if ($validator->fails()) {

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $request['disable_writer_application'] = (isset($request->disable_writer_application)) ? TRUE : NULL;
        $request['show_writer_application_link_website_top_menu'] = (isset($request->show_writer_application_link_website_top_menu)) ? TRUE : NULL;

        $this->save_records($request->only(array_keys($this->recruitmentFields())));

        return redirect()->back()->withSuccess('Successfully updated');
    }

    private function recruitmentFields()
    {
        return [
            'disable_writer_application' => 'nullable',
            'show_writer_application_link_website_top_menu' => 'nullable',
            'writer_application_page_link_title' => 'required|max:100',
            'writer_application_page_title' => 'required|max:255',
            'writer_application_form_title' => 'required|max:255',
            'writer_application_form_subtitle' => 'required|max:255',
            'writer_application_page_content' => 'required',
            'writer_application_form_success_message' => 'required|max:255',
        ];
    }
}
