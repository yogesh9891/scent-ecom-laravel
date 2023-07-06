@if($customer->member)
<p>{{$customer->member->email}} </p>
@else
<h3>No Member</h3>

@endif