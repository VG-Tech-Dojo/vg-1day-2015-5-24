//
//  MessageTableViewCell.swift
//  My1DayApp
//
//  Created by 清 貴幸 on 2015/04/24.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import UIKit

class MessageTableViewCell: UITableViewCell {
    @IBOutlet weak private var iconImageView: UIImageView!
    @IBOutlet weak private var messageLabel: UILabel!
    // Mission1-1 UILabel のインスタンス変数を追加
    @IBOutlet weak var dateLabel: UILabel!
    @IBOutlet weak var userNameLabel: UILabel!
    
    override func prepareForReuse() {
        self.iconImageView.image = nil
        self.messageLabel.text = nil
        // Mission1-1 UILabel のインスタンス変数を初期化
        self.dateLabel.text = nil
        self.userNameLabel.text = nil
    }
    
    func setupComponentsWithMessage(message: Message) {
        if message.body == "daikichi" {
            self.iconImageView.image = UIImage(named:"A.jpeg")
            println("きてる")
        } else{
            self.iconImageView.image = message.icon
        }
        self.messageLabel.text = message.body
        // Mission1-1 UILabel のインスタンス変数に created_at の値を代入
        self.dateLabel.text = message.date
        self.userNameLabel.text = message.userName
    }
}
