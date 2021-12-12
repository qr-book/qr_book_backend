<?php

namespace Src\QRBook\QRCode;

use Src\Core\BaseModel;

class QRCodeModel extends BaseModel
{
    public function findAll($params)
    {
        $statement = "
        SELECT
            c.*
        FROM
            qr_card c
        LEFT JOIN
            qr_user u ON u.id = c.user_id
        WHERE
            u.email = :email
        ";
        return $this->getConnector()->select($statement, $params);
    }

    public function find($params) {
        $statement = "
        SELECT
            c.*
        FROM
            qr_card c
        LEFT JOIN
            qr_user u ON u.id = c.user_id
        WHERE
            c.id = :id
        ";
        return $this->getConnector()->select($statement, $params)[0];
    }

    public function insert($params) {
        $statement = "
        INSERT INTO qr_card
            (title, text, uuid, user_id, light_color, dark_color, frame_id, frame_text, frame_color,
                frame_text_color, quality)
        VALUES
            (:title, :text, :uuid, :user_id, :light_color, :dark_color, :frame_id, :frame_text, :frame_color,
                :frame_text_color, :quality)
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }
    public function update($params) {
        $statement = "
        UPDATE 
            qr_card
        SET
            title=:title,
            text=:text,
            uuid=:uuid,
            light_color=:light_color,
            dark_color=:dark_color,
            frame_id=:frame_id,
            frame_text=:frame_text,
            frame_color=:frame_color,
            frame_text_color=:frame_text_color,
            quality=:quality
        WHERE
            id=:id
        ";
        return $this->getConnector()->executeStatement(
            $statement,
            $params
        );
    }
}
