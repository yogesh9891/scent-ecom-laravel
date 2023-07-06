<label class="switch_toggle" for="active_member{{ $customer->id }}">
    <input type="checkbox" id="active_member{{ $customer->id }}" @if ($customer->is_membership == 1) checked @endif value="{{ $customer->id }}" @if (!permissionCheck('customer.update_is_member_status')) disabled @endif class="update_is_member_status" data-id="{{ $customer->id }}">
    <div class="slider round"></div>
</label>
