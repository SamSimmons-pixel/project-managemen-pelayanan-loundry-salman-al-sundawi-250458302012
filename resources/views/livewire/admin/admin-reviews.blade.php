<div class="main-content">
    <style>
    .reviews-grid .review-item:last-child {
        border-bottom: none;
    }
    </style>
    <div class="header">
        <h1>Reviews & Ratings Analytics</h1>
        <p class="text-muted">Monitor branch performance and customer feedback</p>
    </div>

    <!-- Ratings Section -->
    <div class="card mb-4">
        <h2>Branch Performance Ratings</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Branch Admin</th>
                        <th>Total Reviews</th>
                        <th>Average Rating</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branchAdmins as $index => $admin)
                    <tr>
                        <td>#{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $admin['name'] }}</div>
                            <div style="font-size: 0.85rem; color: #6b7280;">{{ $admin['email'] }}</div>
                        </td>
                        <td>{{ $admin['review_count'] }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 1.1rem; font-weight: 700; color: #374151;">{{ $admin['average_rating'] }}</span>
                                <div style="color: #F59E0B;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($admin['average_rating']))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($admin['average_rating'] >= 4.5)
                                <span class="status-badge status-completed">Excellent</span>
                            @elseif($admin['average_rating'] >= 4.0)
                                <span class="status-badge status-processing">Good</span>
                            @elseif($admin['average_rating'] >= 3.0)
                                <span class="status-badge status-pending">Average</span>
                            @else
                                <span class="status-badge status-cancelled">Needs Improvement</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- All Reviews Section -->
    <div class="header" style="margin-top: 3rem; margin-bottom: 1.5rem;">
        <h2>All Customer Reviews</h2>
    </div>

    @foreach($branchAdmins as $admin)
        @if($admin['review_count'] > 0)
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header" style="border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; margin-bottom: 1rem;">
                <h3 style="color: #374151; font-size: 1.1rem;">
                    <i class="fas fa-store" style="color: #B85C75; margin-right: 0.5rem;"></i>
                    {{ $admin['name'] }} 
                    <span style="font-weight: 400; color: #6b7280; font-size: 0.9rem;">({{ $admin['review_count'] }} reviews)</span>
                </h3>
            </div>
            
            <div class="reviews-grid">
                @foreach($admin['reviews'] as $review)
                <div class="review-item" style="border-bottom: 1px solid #f3f4f6; padding: 1rem 0;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="font-weight: 600; color: #111827;">{{ $review->user->name }}</div>
                            <div style="color: #F59E0B; font-size: 0.9rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div style="color: #9ca3af; font-size: 0.85rem;">
                            {{ $review->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div style="color: #4b5563; line-height: 1.5; margin-bottom: 0.5rem;">
                        {{ $review->comment }}
                    </div>
                    <div style="font-size: 0.8rem; color: #9ca3af;">
                        Order #{{ $review->order->id }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>


