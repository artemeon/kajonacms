<!-- see section "Template-API" of module manual for a list of available placeholders -->
<!-- dynamic sections with schema: level_(x)_(active|inactive)[_first|_last]
     and wrapper sections: level_1_wrapper
     e.g. level_1_active, level_1_active_first, level_2_inactive_last -->

<!-- available placeholders in each section: link, text, href, target, image, page_intern, page_extern, level(x+1) -->


<level_1_wrapper><ul>%%level1%%</ul></level_1_wrapper>

<level_1_active>
<li><a href="%%href%%" target="%%target%%" class="active">%%text%%</a>%%level2%%</li>
</level_1_active>

<level_1_inactive>
<li><a href="%%href%%" target="%%target%%">%%text%%</a></li>
</level_1_inactive>




<level_2_wrapper><ul class="level2">%%level2%%</ul></level_2_wrapper>

<level_2_active>
<li><a href="%%href%%" target="%%target%%" class="active">%%text%%</a>%%level3%%</li>
</level_2_active>

<level_2_inactive>
<li><a href="%%href%%" target="%%target%%">%%text%%</a></li>
</level_2_inactive>




<level_3_wrapper><ul class="level3">%%level3%%</ul></level_3_wrapper>

<level_3_active>
<li><a href="%%href%%" target="%%target%%" class="active">%%text%%</a></li>
</level_3_active>

<level_3_inactive>
<li><a href="%%href%%" target="%%target%%">%%text%%</a></li>
</level_3_inactive>