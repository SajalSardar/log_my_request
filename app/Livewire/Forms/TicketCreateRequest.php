<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use App\Models\RequesterType;
use App\Models\Source;
use App\Models\Team;
use App\Models\TicketStatus;
use Illuminate\Validation\Rule;
use Livewire\Form;

class TicketCreateRequest extends Form
{
    /**
     * Define public property $request_title;
     * @var ?string
     */
    public ?string $request_title;

    /**
     * Define public property $request_description;
     * @var ?string
     */
    public ?string $request_description;

    /**
     * Define public property $requester_name;
     * @var ?string
     */
    public ?string $requester_name;

    /**
     * Define public property $requester_email;
     * @var ?string
     */
    public ?string $requester_email;

    /**
     * Define public property $requester_phone;
     * @var ?string
     */
    public ?string $requester_phone;

    /**
     * Define public property $requester_type_id;
     * @var ?string
     */
    public ?string $requester_type_id;

    /**
     * Define public property $requester_id;
     * @var ?string
     */
    public ?string $requester_id;

    /**
     * Define public property $priority;
     * @var ?string
     */
    public ?string $priority;

    /**
     * Define public property $due_date;
     * @var ?string
     */
    public ?string $due_date;

    /**
     * Define public property $source_id;
     * @var ?string
     */
    public ?string $source_id;

    /**
     * Define public property $category_id;
     * @var ?string
     */
    public ?string $category_id;

    /**
     * Define public property $team_id;
     * @var ?string
     */
    public ?string $team_id;

    /**
     * Define public property $ticket_status_id;
     * @var ?string
     */
    public ?string $ticket_status_id;

    /**
     * Define public property $request_attachment;
     */
    public $request_attachment;

    /**
     * Define public method rules() to validation
     * @return array
     */
    public function rules(): array
    {
        $arr['form.request_title'] = ['required'];
        $arr['form.request_description'] = ['nullable'];
        $arr['form.requester_name'] = ['required'];
        $arr['form.requester_email'] = ['required', 'email'];
        $arr['form.requester_phone'] = ['required', 'string', 'max:15'];
        $arr['form.requester_type_id'] = ['required', Rule::exists(RequesterType::class, 'id')];
        $arr['form.requester_id'] = ['required'];
        $arr['form.priority'] = ['required'];
        $arr['form.due_date'] = ['required'];
        $arr['form.source_id'] = ['required', Rule::exists(Source::class, 'id')];
        $arr['form.category_id'] = ['required', Rule::exists(Category::class, 'id')];
        $arr['form.team_id'] = ['required', Rule::exists(Team::class, 'id')];
        $arr['form.ticket_status_id'] = ['required', Rule::exists(TicketStatus::class, 'id')];
        $arr['form.request_attachment'] = ['required', 'mimes:pdf,docs,ppt', 'max:3024'];
        return $arr;
    }

    /**
     * Define public method attributes()
     * @return array
     */
    public function attributes(): array
    {
        $arr['form.request_title'] = 'request title';
        $arr['form.request_description'] = 'request description';
        $arr['form.requester_name'] = 'requester name';
        $arr['form.requester_email'] = 'requester email';
        $arr['form.requester_phone'] = 'requester phone';
        $arr['form.requester_type_id'] = 'requster type';
        $arr['form.requester_id'] = 'requester id';
        $arr['form.priority'] = 'priority';
        $arr['form.due_date'] = 'due date';
        $arr['form.source_id'] = 'source';
        $arr['form.category_id'] = 'category';
        $arr['form.team_id'] = 'team';
        $arr['form.ticket_status_id'] = 'ticket status';
        $arr['form.request_attachment'] = 'attachment';
        return $arr;
    }
}
