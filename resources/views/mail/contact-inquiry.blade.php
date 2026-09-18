<h1>New portfolio inquiry</h1>

<p><strong>Name:</strong> {{ $senderName }}</p>
<p><strong>Email:</strong> {{ $senderEmail }}</p>
<p><strong>Project type:</strong> {{ $projectType }}</p>

<h2>Message</h2>
<p>{!! nl2br(e($inquiryMessage)) !!}</p>
