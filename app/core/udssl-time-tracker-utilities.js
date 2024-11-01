function updateClock() {
  var currentTime = new Date()
  var currentTimeString = moment(currentTime).format(
    'YYYY-MM-DD hh:mm A'
  )
  var currentTimeStringFull = moment(currentTime).format(
    'YYYY-MM-DD hh:mm:ss A'
  )

  var currentTimeSeconds = moment(currentTime).format('ss')

  if ('00' === currentTimeSeconds) {
    jQuery('#t_end').val(currentTimeString)
  }

  jQuery('#clock').text(currentTimeStringFull)

  /**
   * Time Difference
   */
  var a = moment(
    jQuery('#t_end').val(),
    'YYYY-MM-DD hh:mm A'
  )
  var b = moment(
    jQuery('#t_start').val(),
    'YYYY-MM-DD hh:mm A'
  )
  jQuery('#t_duration').val(a.diff(b, 'minutes'))
}

jQuery(document).ready(function () {
  var currentTime = new Date()
  jQuery('#t_end').val(
    moment(currentTime).format('YYYY-MM-DD hh:mm A')
  )
  jQuery('#pay_time').val(
    moment(currentTime).format('YYYY-MM-DD hh:mm A')
  )

  updateClock()
  setInterval('updateClock()', 1000)
})

function updateClockLocal() {
  var currentTime = new Date()
  var currentTimeString = moment(currentTime).format(
    'YYYY-MM-DD hh:mm:ss A'
  )

  jQuery('#toolbar_clock').text(currentTimeString)

  /**
   * Time Difference
   */
  var a = moment(currentTime)
  var b = moment(
    jQuery('#t_start').val(),
    'YYYY-MM-DD hh:mm A'
  )
  jQuery('#toolbar_duration').text(a.diff(b, 'minutes'))
}

function t_summary() {
  jQuery('#t_summary_table').show()
  jQuery('#t_project_summary_table').html('')
  jQuery('#t_task_summary_table').html('')

  var summary_table = ''

  var summary_array = {}
  var summary_categories = {}
  var summary_projects = {}
  var summary_tasks = {}
  var total = 0

  app.TimeSlots.forEach(function (timeslot) {
    summary_array[timeslot.get('t_category')] = {}
    summary_categories[timeslot.get('t_category')] = 0
  })

  app.TimeSlots.forEach(function (timeslot) {
    summary_array[timeslot.get('t_category')][
      timeslot.get('t_project')
    ] = {}
    summary_projects[timeslot.get('t_project')] = 0
  })

  app.TimeSlots.forEach(function (timeslot) {
    summary_array[timeslot.get('t_category')][
      timeslot.get('t_project')
    ][timeslot.get('t_task')] = 0
    summary_tasks[
      timeslot.get('t_project') +
        ' ' +
        timeslot.get('t_task')
    ] = 0
  })

  app.TimeSlots.forEach(function (timeslot) {
    summary_array[timeslot.get('t_category')][
      timeslot.get('t_project')
    ][timeslot.get('t_task')] += timeslot.get('t_duration')
    summary_tasks[
      timeslot.get('t_project') +
        ' ' +
        timeslot.get('t_task')
    ] += timeslot.get('t_duration')
    summary_projects[timeslot.get('t_project')] +=
      timeslot.get('t_duration')
    summary_categories[timeslot.get('t_category')] +=
      timeslot.get('t_duration')

    total += timeslot.get('t_duration')
  })

  app.total = total

  var t_hours = Math.floor(total / 60)
  var t_minutes = total - t_hours * 60
  if (t_minutes < 10) {
    t_minutes = '0' + t_minutes
  }

  jQuery('#t_summary_total').html(
    '<h1>' + t_hours + ':' + t_minutes + '</h1>'
  )

  var categories = []
  var series = []

  _.each(_.keys(summary_categories), function (category) {
    categories.push(category)
    series.push(summary_categories[category] / 60)
  })

  /**
   * Chart JS Category Summary Plotting
   */
  let labels = categories
  let data = {
    labels: labels,
    datasets: [
      {
        label: 'Category Summary',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: series,
      },
    ],
  }
  let config = {
    type: 'bar',
    data: data,
    options: {},
  }

  var t_summary_chart = new Chart(
    document.getElementById('t_summary_table'),
    config
  )

  categories = []
  series = []

  _.each(_.keys(summary_projects), function (project) {
    categories.push(project)
    series.push(summary_projects[project] / 60)
  })

  /**
   * Chart JS Project Summary Plotting
   */
  labels = categories
  data = {
    labels: labels,
    datasets: [
      {
        label: 'Project Summary',
        backgroundColor: 'rgb(255, 132, 99)',
        borderColor: 'rgb(255, 99, 132)',
        data: series,
      },
    ],
  }
  config = {
    type: 'bar',
    data: data,
    options: {},
  }
  t_project_chart = new Chart(
    document.getElementById('t_project_summary_table'),
    config
  )

  categories = []
  series = []

  _.each(_.keys(summary_tasks), function (task) {
    categories.push(task)
    series.push(summary_tasks[task] / 60)
  })

  /**
   * Chart JS Task Summary Plotting
   */
  labels = categories
  data = {
    labels: labels,
    datasets: [
      {
        label: 'Task Summary',
        backgroundColor: 'rgb(99, 132, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: series,
      },
    ],
  }
  config = {
    type: 'bar',
    data: data,
    options: {},
  }
  t_task_chart = new Chart(
    document.getElementById('t_task_summary_table'),
    config
  )

  jQuery('#t_summary_button').hide()
}

jQuery(document).ready(function () {
  jQuery('.t_add').click(function () {
    var id = jQuery(this).attr('id')
    var parts = id.split('_')

    var newTime = moment(
      jQuery('#t_start').val(),
      'YYYY-MM-DD hh:mm A'
    ).add(parts[2], 'minutes')
    newTime = moment(newTime).format('YYYY-MM-DD hh:mm A')
    jQuery('#t_end').val(newTime)
  })

  jQuery('.t_preset').click(function () {
    var id = jQuery(this).attr('id')
    var parts = id.split('_')

    jQuery('#t_category').val(parts[2]).trigger('change')

    jQuery('#p_category_list')
      .val(parts[2])
      .trigger('change')

    jQuery('#t_project').val(parts[3]).trigger('change')

    jQuery('#ta_project_list')
      .val(parts[3])
      .trigger('change')

    jQuery('#t_task').val(parts[4]).trigger('change')
  })

  jQuery('#t_add_minute').click(function () {
    var newTime = moment(
      jQuery('#t_end').val(),
      'YYYY-MM-DD hh:mm A'
    ).add(1, 'minutes')
    newTime = moment(newTime).format('YYYY-MM-DD hh:mm A')
    jQuery('#t_end').val(newTime)
  })

  jQuery('#t_subtract_minute').click(function () {
    var newTime = moment(
      jQuery('#t_end').val(),
      'YYYY-MM-DD hh:mm A'
    ).subtract('minutes', 1)
    newTime = moment(newTime).format('YYYY-MM-DD hh:mm A')
    jQuery('#t_end').val(newTime)
  })

  jQuery('#t_now_minute').click(function () {
    var newTime = moment()
    newTime = moment(newTime).format('YYYY-MM-DD hh:mm A')
    jQuery('#t_end').val(newTime)
  })

  jQuery('#t_summary_button').click(function () {
    t_summary()
  })

  jQuery('#pay_calculate').click(function () {
    var charge = jQuery('#pay_paid').val() / 10
    var effective = jQuery('#pay_paid').val() - charge
    jQuery('#pay_charges').val(charge)
    jQuery('#pay_effective').val(effective)
  })

  jQuery('.pay_preset').click(function () {
    var id = jQuery(this).attr('id')
    var parts = id.split('_')

    jQuery('#pay_category').val(parts[2]).trigger('change')

    jQuery('#pay_project').val(parts[3]).trigger('change')

    jQuery('#pay_task').val(parts[4]).trigger('change')
  })

  updateClockLocal()
  setInterval('updateClockLocal()', 1000)
})
