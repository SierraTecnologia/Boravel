<table class="table table-sitecpaymentd">
    <thead>
        <tr>
            <th>Plan</th>
            <th>Member</th>
            <th>Sign up Date</th>
            <th>Value</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subscriptions as $subscription)
            @if (siravel()->subscriptionPlan($subscription))
                <tr>
                    <td>{!! $subscription->name !!}</td>
                    <td><a href="{{ url('admin/users/'.$subscription->user->user()->id.'/edit') }}">{{ $subscription->user->user()->name }}</a></td>
                    <td>{{ $subscription->created_at->format('d M, Y') }}</td>
                    <td>${{ siravel()->subscriptionPlan($subscription)->amount }} / {{ siravel()->subscriptionPlan($subscription)->frequency }}</td>
                    <td class="text-right">
                        @if (is_null($subscription->ends_at)) {!! siravel()->cancelSubscriptionBtn($subscription, 'btn btn-sm btn-danger float-right raw-margin-left-8') !!} @endif
                        <a class="btn btn-sm btn-secondary float-right" href="{!! route(config('cms.backend-route-prefix', 'cms').'.plans.edit', [siravel()->subscriptionPlan($subscription)->id]) !!}"><i class="fa fa-pencil"></i> Review Plan</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
