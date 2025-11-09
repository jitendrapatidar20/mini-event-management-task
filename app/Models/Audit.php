<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Audit extends Model
{
    protected $fillable = [
        'user_type', 'user_id', 'event', 'auditable_id', 'auditable_type',
        'old_values', 'new_values', 'ip_address', 'user_agent', 'url'
    ];

    /**
     * Get user's name and role associated with the audit entry.
     *
     * @return array
     */
    public function getUsernamewithroleAttribute()
    {
        $user = User::find($this->user_id);

        if ($user) {
            return [
                'success' => true,
                'name'    => $user->name,
                'role'    => optional($user->getRoleDetail)->title,
            ];
        }

        return ['success' => false];
    }

    /**
     * Get HTML table for old values.
     *
     * @return string
     */
    public function getOldvaluehtmlAttribute()
    {
        $arr = (array) json_decode($this->old_values, true);
        $html = "";

        if (!empty($arr)) {
            $html .= "<table border='1' cellpadding='5' cellspacing='0'>";
            foreach ($arr as $key => $val) {
                $key = e($key);
                $val = is_array($val) ? json_encode($val) : e($val);
                $html .= "<tr><td>{$key}</td><td>{$val}</td></tr>";
            }
            $html .= "</table>";
        }

        return $html;
    }

    /**
     * Get HTML table for new values.
     *
     * @return string
     */
    public function getNewvaluehtmlAttribute()
    {
        $arr = (array) json_decode($this->new_values, true);
        $html = "";

        if (!empty($arr)) {
            $html .= "<table border='1' cellpadding='5' cellspacing='0'>";
            foreach ($arr as $key => $val) {
                $key = e($key);
                $val = is_array($val) ? json_encode($val) : e($val);
                $html .= "<tr><td>{$key}</td><td>{$val}</td></tr>";
            }
            $html .= "</table>";
        }

        return $html;
    }

    /**
     * Get the user who triggered the audit.
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
