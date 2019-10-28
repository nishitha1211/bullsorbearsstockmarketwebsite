from iexfinance.stocks import Stock

from iexfinance.stocks import get_historical_data

#print(get_historical_data("AAPL", output_format='pandas').tail(1))
import sys
import os
import pandas

try:
    if sys.argv[1]!=None:
        print("arg found!")

        arr = sys.argv[1].split(',')

        del arr[-1]
        print(arr)
        os.remove("data.csv")
        for data in arr:

            a = Stock(data)

            price = a.get_price()
            # format for csv   =>   date open    high      low    close   volume price
            df=get_historical_data(data, output_format='pandas').tail(1)

            df['price'] = price
            df['name'] = data
            df.to_csv('data.csv', mode='a', header=False)




    else:
        print("not found")
except: pass


