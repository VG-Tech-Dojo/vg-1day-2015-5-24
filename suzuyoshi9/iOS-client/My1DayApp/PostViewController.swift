//
//  PostViewController.swift
//  My1DayApp
//
//  Created by 清 貴幸 on 2015/05/04.
//  Copyright (c) 2015年 VOYAGE GROUP, inc. All rights reserved.
//

import UIKit

protocol PostViewControllerDelagate : NSObjectProtocol {
    func postViewController(viewController : PostViewController, didTouchUpCloseButton: AnyObject)
}

class PostViewController: UIViewController {
    @IBOutlet weak private var messageTextView: UITextView!
    weak var delegate: PostViewControllerDelagate?
    // Mission1-2 Storyboard から UITextField のインスタンス変数を追加

    override func viewDidLoad() {
        super.viewDidLoad()
        self.messageTextView.becomeFirstResponder()
    }
    
    // MARK: - IBAction
    
    @IBAction func didTouchUpCloseButton(sender: AnyObject) {
        self.messageTextView.resignFirstResponder()
        self.delegate?.postViewController(self, didTouchUpCloseButton: sender)
    }
    
    @IBAction func didTouchUpSendButton(sender: AnyObject) {
        self.messageTextView.resignFirstResponder()
        
        let message: String = self.messageTextView.text ?? ""
        // Mission1-2 UITextField のインスタンス変数から値を取得
        
        // Mission1-2 posetMessage の第2引数に 任意の値を渡す
        APIRequest.postMessage(message, username: "名前はまだない") {
            [weak self] (data, response, error) -> Void in
            
            self?.delegate?.postViewController(self!, didTouchUpCloseButton: sender)
            
            if error != nil {
                // TODO: エラー処理
                println(error)
                return
            }
            
            var decodeError: NSError?
            let responseBody: AnyObject? = NSJSONSerialization.JSONObjectWithData(data, options: NSJSONReadingOptions.allZeros, error: &decodeError)
            if decodeError != nil{
                println(decodeError)
                return
            }
        }
        
    }
}
