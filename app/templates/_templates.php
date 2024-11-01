<script type="text/javascript" >
    var udssl_tt_timeslot = '<?php echo get_home_url() . '/udssl_tt_timeslot/'; ?>';;
    var udssl_tt_category = '<?php echo get_home_url() . '/udssl_tt_category/'; ?>';;
    var udssl_tt_project = '<?php echo get_home_url() . '/udssl_tt_project/'; ?>';;
    var udssl_tt_task = '<?php echo get_home_url() . '/udssl_tt_task/'; ?>';;
    var udssl_tt_payment = '<?php echo get_home_url() . '/udssl_tt_payment/'; ?>';;
</script>

<script type="text/template" id="category-select-template">
    <select id="category-selector">
        <% _(categories).each(function(category) { %>
            <option value="<%= category.c_name %>"><%= category.c_name %></option>
        <% }); %>
    </select>
</script>

<script type="text/template" id="project-select-template">
    <select id="project-selector">
        <% _(projects).each(function(project) { %>
            <% if(category == project.p_category || 'none' == category){  %>
                <option value="<%= project.p_name %>"><%= project.p_name %></option>
            <% } %>
        <% }); %>
    </select>
</script>

<script type="text/template" id="task-select-template">
    <select id="task-selector">
        <% _(tasks).each(function(task) {  %>
            <% if(project == task.ta_project || 'none' == project){  %>
                <option value="<%= task.ta_name %>"><%= task.ta_name %></option>
            <% } %>
        <% }); %>
    </select>
</script>

<script type="text/template" id="time-slot-template">
    <td class="t_start_label" ><%- t_start %></td>
    <td class="t_end_label" ><%- t_end %></td>
    <td class="t_duration_label" ><%- t_duration %></td>
    <td class="t_category_label" ><%- t_category %></td>
    <td class="t_project_label" ><%- t_project %></td>
    <td class="t_task_label" ><%- t_task %></td>
    <td class="t_description_label" ><%- t_description %></td>
</script>

<script type="text/template" id="payment-template">
    <td class="time" ><%- time %></td>
    <td class="category" ><%- category %></td>
    <td class="project" ><%- project %></td>
    <td class="task" ><%- task %></td>
    <td class="paid" ><%- paid %></td>
    <td class="charges" ><%- charges %></td>
    <td class="effective" ><%- effective %></td>
</script>

<script type="text/template" id="time-template">
    <span id="slot-count"><strong><%= total_slots %></strong></span>
</script>
