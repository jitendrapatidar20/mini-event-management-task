<div class="form-group mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $event->title ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
</div>

<div class="form-group mb-3">
    <label>Start Time</label>
    <input type="datetime-local" name="start_time" class="form-control"
           value="{{ old('start_time', isset($event->start_time) ? \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i') : '') }}" required>
</div>

<div class="form-group mb-3">
    <label>End Time</label>
    <input type="datetime-local" name="end_time" class="form-control"
           value="{{ old('end_time', isset($event->end_time) ? \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i') : '') }}" required>
</div>

<div class="form-group mb-3">
    <label>Location</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $event->location ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label>Total Seats</label>
    <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats', $event->total_seats ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label>Available Seats</label>
    <input type="number" name="available_seats" class="form-control" value="{{ old('available_seats', $event->available_seats ?? '') }}" required>
</div>
