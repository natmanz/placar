<?php

require_once '../functions.php';

// TODO INCLUDE AUTHENTICATION

/*
Statuses:
- Greater than 500 means error occured procession request.
- Less than 200 means success.
*/
$result = array();

$team_manager = TeamManager::get();

if (!isset($_GET['method']))
{
	$result['status'] = 501;
	$result['message'] = 'No method included...';
	show_result();
}

$method = $_GET['method'];

switch ($method)
{
	case 'points':
		handle_points();
		break;
	case 'team':
		handle_team();
		break;
	default:
		$result['status'] = 502;
		$result['message'] = 'Invalid method given!';
		show_result();
		break;
}

function handle_points()
{
	global $result, $team_manager;
	if (!isset($_GET['action']))
	{
		$result['status'] = 503;
		$result['message'] = 'Points: No action given!';
		show_result();
	}
	if (!isset($_GET['team_name']))
	{
		$result['status'] = 504;
		$result['message'] = 'Points: No team name!';
		show_result();
	}
	if (!isset($_GET['value']))
	{
		$result['status'] = 505;
		$result['message'] = 'Points: No value given!';
		show_result();
	}
	$action = $_GET['action'];
	$team_name = $_GET['team_name'];
	$value = (int) $_GET['value'];
	switch ($action)
	{
		case 'add':
			if ($team_manager->addTeamPoints($team_name, $value))
			{
				$result['status'] = 101;
				$result['message'] = 'Points: Added points to ' . $team_name;
				show_result();
			}
			break;
		case 'remove':
			if ($team_manager->removeTeamPoints($team_name, $value))
			{
				$result['status'] = 102;
				$result['message'] = 'Points: Removed points from ' . $team_name;
				show_result();
			}
			break;
		case 'set':
			if ($team_manager->setTeamPoints($team_name, $value))
			{
				$result['status'] = 103;
				$result['message'] = 'Points: Set the points to ' . $team_name;
				show_result();
			}
			break;
		default:
			$result['status'] = 506;
			$result['message'] = 'Points: No value given!';
			show_result();
	}
	$result['status'] = 507;
	$result['message'] = 'Points: Something failed when processing your action!';
	show_result();
}

function handle_team()
{
	// TODO
}

function show_result()
{
	global $result;
	header('Content-type: application/json');
	echo json_encode($result);
	exit;
}