<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
{{-- <img src="{{ get_company_logo() }}" class="logo" alt="{{ get_company_name() }}"> --}}
{{ get_company_name() }}
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
