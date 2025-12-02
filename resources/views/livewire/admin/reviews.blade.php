<div class="main-content">
    <div class="header">
        <h1>Reviews & Ratings</h1>
    </div>

    @foreach($branchAdmins as $data)
    <div class="card">
        <h2>Reviews for {{ $data['admin']->name }} ({{ $data['admin']->email }})</h2>
        
        @if($data['reviews']->isEmpty())
            <p>No reviews found for this branch.</p>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Order ID</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['reviews'] as $review)
                        <tr>
                            <td>{{ $review->user->name }}</td>
                            <td>#{{ $review->order->id }}</td>
                            <td>
                                <span class="status-badge status-completed">
                                    {{ $review->rating }} / 5 ⭐
                                </span>
                            </td>
                            <td>{{ $review->comment }}</td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @endforeach
</div>
