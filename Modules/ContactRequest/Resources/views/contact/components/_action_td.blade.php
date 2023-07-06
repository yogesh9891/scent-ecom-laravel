@if (permissionCheck('contactrequest.contact.delete'))
    <!-- shortby  -->
    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            {{ __('common.select') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
            <a href="{{ route('contactrequest.contact.show', $ContactList->id) }}"
                class="dropdown-item edit_brand">{{ __('common.show') }}</a>
            <a href="#" class="dropdown-item edit_brand"
                onclick="showDeleteModal({{ $ContactList->id }})">{{ __('common.delete') }}</a>
        </div>
    </div>
    <!-- shortby  -->
@else
    <button class="primary_btn_2" type="button">No Action Permitted</button>
@endif
