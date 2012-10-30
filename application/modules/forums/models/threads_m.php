<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
 * 
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Dove Forums
 * @copyright Copyright (c) 2012 - Christopher Baines
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://www.doveforums.com
 * @since v 2.0.0
 * @author Christopher Baines
 * 
 */

class threads_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
    
    public function get_forum_threads($forum_id)
    {
        // Set the select.
        $this->db->select('
            threads.id,
            threads.forum_id,
            threads.title,
            threads.permalink,
            threads.started_by,
            threads.last_activity,
            threads.last_post_by,
            threads.status,
            threads.visibility,
            threads.tags,
            threads.type,
            users.username,
            users.email,
        ');
        
        // Set the join.
        $this->db->join('users', 'users.username = threads.started_by');
        
        // Set some options.
        $options = array(
            'forum_id' => $forum_id,
            'status' => 'open',
            'visibility' => 'public',
        );

        // Perform the query.
        $query = $this->db->get_where('threads', $options);
        
        // Results.
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                $data[] = array(
                    'id' => $row['id'],
                    'forum_id' => $row['forum_id'],
                    'title' => $row['title'],
                    'permalink' => $row['permalink'],
                    'started_by' => $row['started_by'],
                    'last_activity' => $row['last_activity'],
                    'last_post_by' => $row['last_post_by'],
                    'status' => $row['status'],
                    'visibility' => $row['visibility'],
                    'tags' => $row['tags'],
                    'type' => $row['type'],
                );
            }
            
            return $data;
        } else {
            return false;
        }
    }
    
    public function get_name_from_permalink($thread_permalink)
    {
        // Set the select.
        $this->db->select('title');
        
        // Set some options.
        $options = array(
            'permalink' => $thread_permalink,
        );
        
        // Perform the query.
        $query = $this->db->get_where('threads', $options);
        
        // Results.
        if($query->num_rows() > 0)
        {
            return $query->row('title');
        } else {
            return false;
        }
    }
    
    public function get_id_from_permalink($thread_permalink)
    {
        // Set the select.
        $this->db->select('id');
        
        // Set some options.
        $options = array(
            'permalink' => $thread_permalink,
        );
        
        // Perform the query.
        $query = $this->db->get_where('threads', $options);
        
        // Results.
        if($query->num_rows() > 0)
        {
            return $query->row('id');
        } else {
            return false;
        }
    }
    
    public function count_forum_threads($forum_id)
    {
        // Set some options.
        $options = array(
            'forum_id' => $forum_id,
        );
        
        // Perform the query.
        $query = $this->db->get_where('threads', $options);
        
        // Results.
        if($query->num_rows() > 0)
        {
            return $query->num_rows();
        } else {
            return '0';
        }
    }
}