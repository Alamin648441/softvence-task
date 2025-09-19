<?php

namespace App\Http\Controllers;

use App\Http\Requests\userRequest;
use App\Models\Course;


class CourseController extends Controller
{
    public function create()
    {

        return view('courses.create');
    }

    public function store(userRequest $req)
    {
        $validatedData = $req->validated();


        try {
            $course = Course::create([
                'title' => $validatedData['title'],
                'category' => $validatedData['category'],
                'description' => $validatedData['description'] ?? null,

            ]);

            if (!empty($validatedData['modules']) && is_array($validatedData['modules'])) {
                foreach ($validatedData['modules'] as $moduleIndex => $moduleData) {
                    $module = $course->modules()->create([
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'],
                        'order' => $moduleIndex,
                    ]);

                    if (!empty($moduleData['contents']) && is_array($moduleData['contents'])) {
                        foreach ($moduleData['contents'] as $contentIndex => $contentData) {
                            $module->contents()->create([
                                'type' => $contentData['type'],
                                'title' => $contentData['title'] ?? null,
                                'body' => $contentData['body'] ?? null,
                                'order' => $contentIndex,
                            ]);
                        }
                    }
                }
            }
            return redirect()->back()->with('success', 'course created successfully !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'invalid request' . $e->getMessage());
        }
    }
}
